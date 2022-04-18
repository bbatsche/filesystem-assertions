<?php

declare(strict_types=1);

namespace BeBat\FilesystemAssertions\Test\Unit;

use BeBat\FilesystemAssertions\Constraint\HasLinkTarget;
use Codeception\AssertThrows;
use phpmock\functions\FixedValueFunction;
use phpmock\spy\Spy;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class HasLinkTargetTest extends TestCase
{
    use AssertThrows;
    use SpyHadArgumentsTrait;

    /** @var Spy */
    private $readlinkSpy;

    protected function setUp(): void
    {
        $this->readlinkSpy = new Spy(
            'BeBat\\FilesystemAssertions\\Constraint',
            'readlink',
            (new FixedValueFunction('/some/other/file'))->getCallable()
        );

        $this->readlinkSpy->enable();
    }

    protected function tearDown(): void
    {
        $this->readlinkSpy->disable();
    }

    public function testConstraint(): void
    {
        $constraint = new HasLinkTarget('/some/other/file');
        self::assertTrue($constraint->evaluate('/some/file/path', '', true));

        $constraint = new HasLinktarget('/another/file/path');
        self::assertFalse($constraint->evaluate('/some/other/path', '', true));

        $this->assertSpyHadArguments($this->readlinkSpy, ['/some/file/path'], 0);
        $this->assertSpyHadArguments($this->readlinkSpy, ['/some/other/path'], 1);
    }

    public function testFailureMessage(): void
    {
        $constraint = new HasLinkTarget('/another/file/path');
        $exception  = new ExpectationFailedException('Failed asserting that symbolic link "/some/file/path" points to "/another/file/path".');

        $this->assertThrows($exception, static function () use ($constraint): void {
            $constraint->evaluate('/some/file/path');
        });

        $this->assertSpyHadArguments($this->readlinkSpy, ['/some/file/path'], 0);
    }

    public function testToString(): void
    {
        $constraint = new HasLinkTarget('/some/other/file');

        self::assertSame('symbolic link points to "/some/other/file"', $constraint->toString());
    }
}
