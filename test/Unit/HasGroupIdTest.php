<?php

declare(strict_types=1);

namespace BeBat\FilesystemAssertions\Test\Unit;

use BeBat\FilesystemAssertions\Constraint\HasGroupId;
use Codeception\AssertThrows;
use phpmock\functions\FixedValueFunction;
use phpmock\spy\Spy;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class HasGroupIdTest extends TestCase
{
    use AssertThrows;
    use SpyHadArgumentsTrait;

    /** @var Spy */
    private $filegroupSpy;

    protected function setUp(): void
    {
        $this->filegroupSpy = new Spy(
            'BeBat\\FilesystemAssertions\\Constraint',
            'filegroup',
            (new FixedValueFunction(501))->getCallable()
        );

        $this->filegroupSpy->enable();
    }

    protected function tearDown(): void
    {
        $this->filegroupSpy->disable();
    }

    public function testConstraint(): void
    {
        $constraint = new HasGroupId(501);
        self::assertTrue($constraint->evaluate('/some/file/path', '', true));

        $constraint = new HasGroupId(502);
        self::assertFalse($constraint->evaluate('/some/other/path', '', true));

        $this->assertSpyHadArguments($this->filegroupSpy, ['/some/file/path'], 0);
        $this->assertSpyHadArguments($this->filegroupSpy, ['/some/other/path'], 1);
    }

    public function testFailureMessage(): void
    {
        $constraint = new HasGroupId(502);
        $exception  = new ExpectationFailedException('Failed asserting that file "/some/file/path" has group ID 502.');

        $this->assertThrows($exception, static function () use ($constraint): void {
            $constraint->evaluate('/some/file/path');
        });

        $this->assertSpyHadArguments($this->filegroupSpy, ['/some/file/path'], 0);
    }

    public function testToString(): void
    {
        $constraint = new HasGroupId(501);

        self::assertSame('file has group ID 501', $constraint->toString());
    }
}
