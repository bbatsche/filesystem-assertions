<?php

declare(strict_types=1);

namespace BeBat\FilesystemAssertions\Constraint;

use PHPUnit\Framework\Constraint\Constraint;

/**
 * File permissions are a given value.
 */
final class PermsEqual extends Constraint
{
    /** @var string */
    private $perms;

    /**
     * @param string $perms octal value encoded as a string
     */
    public function __construct(string $perms)
    {
        $this->perms = $perms;
    }

    public function toString(): string
    {
        return 'file has permissions ' . $this->perms;
    }

    /**
     * @param string $file
     */
    protected function failureDescription($file): string
    {
        return sprintf('file "%s" has permissions %s', $file, $this->perms);
    }

    /**
     * @param string $file
     */
    protected function matches($file): bool
    {
        return mb_substr(decoct((int) fileperms($file)), -3) === $this->perms;
    }
}
