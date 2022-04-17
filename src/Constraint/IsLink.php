<?php

declare(strict_types=1);

namespace BeBat\FilesystemAssert\Constraint;

use PHPUnit\Framework\Constraint\Constraint;

/**
 * File is symbolic link.
 */
final class IsLink extends Constraint
{
    public function toString(): string
    {
        return 'symbolic link exists';
    }

    /**
     * @param string $file
     */
    protected function failureDescription($file): string
    {
        return sprintf('symbolic link "%s" exists', $file);
    }

    /**
     * @param string $file
     */
    protected function matches($file): bool
    {
        return is_link($file);
    }
}
