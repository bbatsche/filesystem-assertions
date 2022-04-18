<?php

declare(strict_types=1);

namespace BeBat\FilesystemAssertions\Constraint;

use PHPUnit\Framework\Constraint\Constraint;

/**
 * Symbolic link points to a particular file.
 */
final class HasLinkTarget extends Constraint
{
    /** @var string */
    private $target;

    public function __construct(string $target)
    {
        $this->target = $target;
    }

    public function toString(): string
    {
        return sprintf('symbolic link points to "%s"', $this->target);
    }

    /**
     * @param string $symlink
     */
    protected function failureDescription($symlink): string
    {
        return sprintf('symbolic link "%s" points to "%s"', $symlink, $this->target);
    }

    /**
     * @param string $symlink
     */
    protected function matches($symlink): bool
    {
        return readlink($symlink) === $this->target;
    }
}
