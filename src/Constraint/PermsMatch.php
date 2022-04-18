<?php

declare(strict_types=1);

namespace BeBat\FilesystemAssertions\Constraint;

use PHPUnit\Framework\Constraint\Constraint;

/**
 * File permissions include a minimal set of permissions.
 */
final class PermsMatch extends Constraint
{
    /** @var int */
    private $perms;

    /**
     * @param int $perms permission encoded as an integer
     */
    public function __construct(int $perms)
    {
        $this->perms = $perms;
    }

    public function toString(): string
    {
        return 'file includes permissions ' . decoct($this->perms);
    }

    /**
     * @param string $file
     */
    protected function failureDescription($file): string
    {
        return sprintf('file "%s" includes permissions %o', $file, $this->perms);
    }

    /**
     * @param string $file
     */
    protected function matches($file): bool
    {
        return (fileperms($file) & $this->perms) === $this->perms;
    }
}
