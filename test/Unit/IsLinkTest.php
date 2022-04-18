<?php

declare(strict_types=1);

namespace BeBat\FilesystemAssertions\Test\Unit;

use BeBat\FilesystemAssertions\Constraint\IsLink;
use Codeception\AssertThrows;
use phpmock\Mock;
use phpmock\MockBuilder;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class IsLinkTest extends TestCase
{
    use AssertThrows;
    use SpyHadArgumentsTrait;

    /** @var Mock */
    private $isLinkMock;

    protected function setUp(): void
    {
        $this->isLinkMock = (new MockBuilder())
            ->setNamespace('BeBat\\FilesystemAssertions\\Constraint')
            ->setName('is_link')
            ->setFunction(static function (string $path): bool {
                return $path === '/some/symbolic/link';
            })->build();

        $this->isLinkMock->enable();
    }

    protected function tearDown(): void
    {
        $this->isLinkMock->disable();
    }

    public function testConstraint(): void
    {
        $constraint = new IsLink();

        self::assertTrue($constraint->evaluate('/some/symbolic/link', '', true));
        self::assertFalse($constraint->evaluate('/some/other/file', '', true));
    }

    public function testFailureMessage(): void
    {
        $constraint = new IsLink();
        $exception  = new ExpectationFailedException('Failed asserting that symbolic link "/some/file/path" exists.');

        $this->assertThrows($exception, static function () use ($constraint): void {
            $constraint->evaluate('/some/file/path');
        });
    }

    public function testToString(): void
    {
        $constraint = new IsLink();

        self::assertSame('symbolic link exists', $constraint->toString());
    }
}
