<?php

declare(strict_types=1);

namespace BeBat\FilesystemAssert\Constraint;

use PHPUnit\Framework\Constraint\Constraint;

/**
 * File has group ID.
 */
final class HasGroupId extends Constraint
{
    /** @var int */
    private $gid;

    public function __construct(int $gid)
    {
        $this->gid = $gid;
    }

    public function toString(): string
    {
        return 'file has group ID ' . $this->gid;
    }

    /**
     * @param string $file
     */
    protected function failureDescription($file): string
    {
        return sprintf('file "%s" has group ID %d', $file, $this->gid);
    }

    /**
     * @param string $file
     */
    protected function matches($file): bool
    {
        return filegroup($file) === $this->gid;
    }
}
