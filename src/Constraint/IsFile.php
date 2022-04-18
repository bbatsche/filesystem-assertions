<?php

declare(strict_types=1);

namespace BeBat\FilesystemAssertions\Constraint;

use PHPUnit\Framework\Constraint\Constraint;

/**
 * Path is a regular file.
 */
final class IsFile extends Constraint
{
    public function toString(): string
    {
        return 'is a regular file';
    }

    /**
     * @param string $file
     */
    protected function failureDescription($file): string
    {
        return sprintf('"%s" is a regular file', $file);
    }

    /**
     * @param string $file
     */
    protected function matches($file): bool
    {
        return is_file($file);
    }
}
