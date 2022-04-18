<?php

declare(strict_types=1);

namespace BeBat\FilesystemAssert\Test\Unit;

use phpmock\spy\Spy;
use PHPUnit\Framework\Assert;

trait SpyHadArgumentsTrait
{
    /**
     * Assert a given invocation of a phpmock Spy had some arguments.
     *
     * @param non-empty-array<int, mixed> $args
     */
    protected function assertSpyHadArguments(Spy $spy, array $args, int $invocation = 0, string $message = ''): void
    {
        Assert::assertSame($args, $spy->getInvocations()[$invocation]->getArguments(), $message);
    }
}
