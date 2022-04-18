<?php

declare(strict_types=1);

namespace BeBat\FilesystemAssertions\Test\Unit;

use BeBat\FilesystemAssertions\Constraint\IsFile;
use Codeception\AssertThrows;
use phpmock\Mock;
use phpmock\MockBuilder;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class IsFileTest extends TestCase
{
    use AssertThrows;
    use SpyHadArgumentsTrait;

    /** @var Mock */
    private $IsFileMock;

    protected function setUp(): void
    {
        $this->IsFileMock = (new MockBuilder())
            ->setNamespace('BeBat\\FilesystemAssertions\\Constraint')
            ->setName('is_file')
            ->setFunction(static function (string $path): bool {
                return $path === '/some/normal/file';
            })->build();

        $this->IsFileMock->enable();
    }

    protected function tearDown(): void
    {
        $this->IsFileMock->disable();
    }

    public function testConstraint(): void
    {
        $constraint = new IsFile();

        self::assertTrue($constraint->evaluate('/some/normal/file', '', true));
        self::assertFalse($constraint->evaluate('/some/other/file', '', true));
    }

    public function testFailureMessage(): void
    {
        $constraint = new IsFile();
        $exception  = new ExpectationFailedException('Failed asserting that "/some/file/path" is a regular file.');

        $this->assertThrows($exception, static function () use ($constraint): void {
            $constraint->evaluate('/some/file/path');
        });
    }

    public function testToString(): void
    {
        $constraint = new IsFile();

        self::assertSame('is a regular file', $constraint->toString());
    }
}
