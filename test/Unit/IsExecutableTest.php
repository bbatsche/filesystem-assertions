<?php

declare(strict_types=1);

namespace BeBat\FilesystemAssert\Test\Unit;

use BeBat\FilesystemAssert\Constraint\IsExecutable;
use Codeception\AssertThrows;
use phpmock\Mock;
use phpmock\MockBuilder;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class IsExecutableTest extends TestCase
{
    use AssertThrows;
    use SpyHadArgumentsTrait;

    /** @var Mock */
    private $isExecutableMock;

    protected function setUp(): void
    {
        $this->isExecutableMock = (new MockBuilder())
            ->setNamespace('BeBat\\FilesystemAssert\\Constraint')
            ->setName('is_executable')
            ->setFunction(static function (string $path): bool {
                return $path === '/some/executable/file';
            })->build();

        $this->isExecutableMock->enable();
    }

    protected function tearDown(): void
    {
        $this->isExecutableMock->disable();
    }

    public function testConstraint(): void
    {
        $constraint = new IsExecutable();

        self::assertTrue($constraint->evaluate('/some/executable/file', '', true));
        self::assertFalse($constraint->evaluate('/some/other/file', '', true));
    }

    public function testFailureMessage(): void
    {
        $constraint = new IsExecutable();
        $exception  = new ExpectationFailedException('Failed asserting that file "/some/file/path" is executable.');

        $this->assertThrows($exception, static function () use ($constraint): void {
            $constraint->evaluate('/some/file/path');
        });
    }

    public function testToString(): void
    {
        $constraint = new IsExecutable();

        self::assertSame('file is executable', $constraint->toString());
    }
}
