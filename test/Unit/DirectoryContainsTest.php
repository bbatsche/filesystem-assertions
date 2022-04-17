<?php

declare(strict_types=1);

namespace BeBat\FilesystemAssert\Test\Unit;

use BeBat\FilesystemAssert\Constraint\DirectoryContains;
use Codeception\AssertThrows;
use phpmock\functions\FixedValueFunction;
use phpmock\spy\Spy;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class DirectoryContainsTest extends TestCase
{
    use AssertThrows;
    use SpyHadArgumentsTrait;

    /** @var Spy */
    private $scandirSpy;

    protected function setUp(): void
    {
        $this->scandirSpy = new Spy(
            'BeBat\\FilesystemAssert\\Constraint',
            'scandir',
            (new FixedValueFunction(['.', '..', 'file1', 'file2', 'file3']))->getCallable()
        );

        $this->scandirSpy->enable();
    }

    protected function tearDown(): void
    {
        $this->scandirSpy->disable();
    }

    public function testConstraint(): void
    {
        $constraint = new DirectoryContains(['file1', 'file2']);
        self::assertTrue($constraint->evaluate('/some/file/path', '', true));

        $constraint = new DirectoryContains(['file3', 'file4']);
        self::assertFalse($constraint->evaluate('/some/other/path', '', true));

        $this->assertSpyHadArguments($this->scandirSpy, ['/some/file/path'], 0);
        $this->assertSpyHadArguments($this->scandirSpy, ['/some/other/path'], 1);
    }

    public function testFailureMessage(): void
    {
        $constraint = new DirectoryContains(['file3', 'file4']);
        $exception  = new ExpectationFailedException('Failed asserting that directory "/some/file/path" contains "file3, file4".');

        $this->assertThrows($exception, static function () use ($constraint): void {
            $constraint->evaluate('/some/file/path');
        });

        $this->assertSpyHadArguments($this->scandirSpy, ['/some/file/path']);
    }

    public function testToString(): void
    {
        $constraint = new DirectoryContains(['file1', 'file2']);

        self::assertSame('directory contains "file1, file2"', $constraint->toString());
    }
}
