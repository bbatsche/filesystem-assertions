<?php

declare(strict_types=1);

namespace BeBat\FilesystemAssertions\Test\Unit;

use BeBat\FilesystemAssertions\Constraint\PermsMatch;
use Codeception\AssertThrows;
use phpmock\functions\FixedValueFunction;
use phpmock\spy\Spy;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class PermsMatchTest extends TestCase
{
    use AssertThrows;
    use SpyHadArgumentsTrait;

    /** @var Spy */
    private $filepermsSpy;

    protected function setUp(): void
    {
        $this->filepermsSpy = new Spy(
            'BeBat\\FilesystemAssertions\\Constraint',
            'fileperms',
            (new FixedValueFunction(octdec('100644')))->getCallable()
        );

        $this->filepermsSpy->enable();
    }

    protected function tearDown(): void
    {
        $this->filepermsSpy->disable();
    }

    public function testConstraint(): void
    {
        $constraint = new PermsMatch((int) octdec('644'));
        self::assertTrue($constraint->evaluate('/some/file/path', '', true));
        $constraint = new PermsMatch((int) octdec('400'));
        self::assertTrue($constraint->evaluate('/some/other/path', '', true));

        $constraint = new PermsMatch((int) octdec('755'));
        self::assertFalse($constraint->evaluate('/yet/another/path', '', true));
        $constraint = new PermsMatch((int) octdec('611'));
        self::assertFalse($constraint->evaluate('/one/more/path', '', true));

        $this->assertSpyHadArguments($this->filepermsSpy, ['/some/file/path'], 0);
        $this->assertSpyHadArguments($this->filepermsSpy, ['/some/other/path'], 1);
        $this->assertSpyHadArguments($this->filepermsSpy, ['/yet/another/path'], 2);
        $this->assertSpyHadArguments($this->filepermsSpy, ['/one/more/path'], 3);
    }

    public function testFailureMessage(): void
    {
        $constraint = new PermsMatch((int) octdec('755'));
        $exception  = new ExpectationFailedException('Failed asserting that file "/some/file/path" includes permissions 755.');

        $this->assertThrows($exception, static function () use ($constraint): void {
            $constraint->evaluate('/some/file/path');
        });

        $this->assertSpyHadArguments($this->filepermsSpy, ['/some/file/path'], 0);
    }

    public function testToString(): void
    {
        $constraint = new PermsMatch((int) octdec('644'));

        self::assertSame('file includes permissions 644', $constraint->toString());
    }
}
