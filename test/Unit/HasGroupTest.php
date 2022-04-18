<?php

declare(strict_types=1);

namespace BeBat\FilesystemAssertions\Test\Unit;

use BeBat\FilesystemAssertions\Constraint\HasGroup;
use Codeception\AssertThrows;
use phpmock\Mock;
use phpmock\MockBuilder;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class HasGroupTest extends TestCase
{
    use AssertThrows;

    /** @var Mock */
    private $filegroupMock;

    /** @var Mock */
    private $getgrgidMock;

    protected function setUp(): void
    {
        $this->filegroupMock = (new MockBuilder())
            ->setNamespace('BeBat\\FilesystemAssertions\\Constraint')
            ->setName('filegroup')
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

        $this->getgrgidMock = (new MockBuilder())
            ->setNamespace('BeBat\\FilesystemAssertions\\Constraint')
            ->setName('posix_getgrgid')
            ->setFunction(
                static function (int $gid) {
                    switch ($gid) {
                        case 501:
                            return [
                                'name'    => 'mygroup',
                                'passwd'  => '*',
                                'gid'     => 501,
                                'members' => ['foo', 'bar'],
                            ];

                        case 502:
                            return [
                                'name'    => 'anothergroup',
                                'passwd'  => '*',
                                'gid'     => 502,
                                'members' => ['fizz', 'buzz'],
                            ];

                        default:
                            return false;
                    }
                }
            )->build();

        $this->filegroupMock->enable();
        $this->getgrgidMock->enable();
    }

    protected function tearDown(): void
    {
        $this->filegroupMock->disable();
        $this->getgrgidMock->disable();
    }

    public function testConstraint(): void
    {
        $constraint = new HasGroup('mygroup');

        self::assertTrue($constraint->evaluate('/some/file/path', '', true));
        self::assertFalse($constraint->evaluate('/some/other/path', '', true));
        self::assertFalse($constraint->evaluate('/yet/another/path', '', true));
        self::assertFalse($constraint->evaluate('/some/unknown/path', '', true));
    }

    public function testFailureMessage(): void
    {
        $constraint = new HasGroup('someothergroup');
        $exception  = new ExpectationFailedException('Failed asserting that file "/some/file/path" belongs to group "someothergroup".');

        $this->assertThrows($exception, static function () use ($constraint): void {
            $constraint->evaluate('/some/file/path');
        });
    }

    public function testToString(): void
    {
        $constraint = new HasGroup('mygroup');

        self::assertSame('file belongs to group "mygroup"', $constraint->toString());
    }
}
