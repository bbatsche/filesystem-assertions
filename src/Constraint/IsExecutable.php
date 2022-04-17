<?php

declare(strict_types=1);

namespace BeBat\FilesystemAssert\Constraint;

use PHPUnit\Framework\Constraint\Constraint;

/**
 * File is executable.
 */
final class IsExecutable extends Constraint
{
    public function toString(): string
    {
        return 'file is executable';
    }

    /**
     * @param string $file
     */
    protected function failureDescription($file): string
    {
        return sprintf('file "%s" is executable', $file);
    }

    /**
     * @param string $file
     */
    protected function matches($file): bool
    {
        return is_executable($file);
    }
}
