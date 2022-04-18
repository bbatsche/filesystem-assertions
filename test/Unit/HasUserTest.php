<?php

declare(strict_types=1);

namespace BeBat\FilesystemAssertions\Test\Unit;

use BeBat\FilesystemAssertions\Constraint\HasUser;
use Codeception\AssertThrows;
use phpmock\Mock;
use phpmock\MockBuilder;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class HasUserTest extends TestCase
{
    use AssertThrows;

    /** @var Mock */
    private $fileownerSpy;

    /** @var Mock */
    private $getpwuidSpy;

    protected function setUp(): void
    {
        $this->fileownerSpy = (new MockBuilder())
            ->setNamespace('BeBat\\FilesystemAssertions\\Constraint')
            ->setName('fileowner')
            ->setFunction(
                static function (string $path) {
                    switch ($path) {
                        case '/some/file/path':
                            return 501;

                        case '/some/other/path':
                            return 502;

                        case '/yet/another/path':
                            return 503;

                        default:
                            return false;
                    }
                }
            )->build();

        $this->getpwuidSpy = (new MockBuilder())
            ->setNamespace('BeBat\\FilesystemAssertions\\Constraint')
            ->setName('posix_getpwuid')
            ->setFunction(
                static function (int $gid) {
                    switch ($gid) {
                        case 501:
                            return [
                                'name'   => 'myuser',
                                'passwd' => '*',
                                'uid'    => 501,
                                'gid'    => 20,
                                'gecos'  => 'My User',
                                'dir'    => '/Users/myuser',
                                'shell'  => '/usr/local/bin/fish',
                            ];

                        case 502:
                            return [
                                'name'   => 'anotheruser',
                                'passwd' => '*',
                                'uid'    => 502,
                                'gid'    => 20,
                                'gecos'  => 'Another User',
                                'dir'    => '/Users/anotheruser',
                                'shell'  => '/bin/zsh',
                            ];

                        default:
                            return false;
                    }
                }
            )->build();

        $this->fileownerSpy->enable();
        $this->getpwuidSpy->enable();
    }

    protected function tearDown(): void
    {
        $this->fileownerSpy->disable();
        $this->getpwuidSpy->disable();
    }

    public function testConstraint(): void
    {
        $constraint = new HasUser('myuser');

        self::assertTrue($constraint->evaluate('/some/file/path', '', true));
        self::assertFalse($constraint->evaluate('/some/other/path', '', true));
        self::assertFalse($constraint->evaluate('/some/unknown/path', '', true));
        self::assertFalse($constraint->evaluate('/yet/another/path', '', true));
    }

    public function testFailureMessage(): void
    {
        $constraint = new HasUser('anotheruser');
        $exception  = new ExpectationFailedException('Failed asserting that file "/some/file/path" is owned by "anotheruser".');

        $this->assertThrows($exception, static function () use ($constraint): void {
            $constraint->evaluate('/some/file/path');
        });
    }

    public function testToString(): void
    {
        $constraint = new HasUser('myuser');

        self::assertSame('file is owned by "myuser"', $constraint->toString());
    }
}
