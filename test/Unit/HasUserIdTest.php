<?php

declare(strict_types=1);

namespace BeBat\FilesystemAssert\Test\Unit;

use BeBat\FilesystemAssert\Constraint\HasUserId;
use Codeception\AssertThrows;
use phpmock\functions\FixedValueFunction;
use phpmock\spy\Spy;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class HasUserIdTest extends TestCase
{
    use AssertThrows;
    use SpyHadArgumentsTrait;

    /** @var Spy */
    private $fileownerSpy;

    protected function setUp(): void
    {
        $this->fileownerSpy = new Spy(
            'BeBat\\FilesystemAssert\\Constraint',
            'fileowner',
            (new FixedValueFunction(501))->getCallable()
        );

        $this->fileownerSpy->enable();
    }

    protected function tearDown(): void
    {
        $this->fileownerSpy->disable();
    }

    public function testConstraint(): void
    {
        $constraint = new HasUserId(501);
        self::assertTrue($constraint->evaluate('/some/file/path', '', true));

        $constraint = new HasUserId(502);
        self::assertFalse($constraint->evaluate('/some/other/path', '', true));

        $this->assertSpyHadArguments($this->fileownerSpy, ['/some/file/path'], 0);
        $this->assertSpyHadArguments($this->fileownerSpy, ['/some/other/path'], 1);
    }

    public function testFailureMessage(): void
    {
        $constraint = new HasUserId(502);
        $exception  = new ExpectationFailedException('Failed asserting that file "/some/file/path" is owned by 502.');

        $this->assertThrows($exception, static function () use ($constraint): void {
            $constraint->evaluate('/some/file/path');
        });

        $this->assertSpyHadArguments($this->fileownerSpy, ['/some/file/path'], 0);
    }

    public function testToString(): void
    {
        $constraint = new HasUserId(501);

        self::assertSame('file is owned by 501', $constraint->toString());
    }
}
