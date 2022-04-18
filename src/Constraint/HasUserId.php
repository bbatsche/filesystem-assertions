<?php

declare(strict_types=1);

namespace BeBat\FilesystemAssertions\Constraint;

use PHPUnit\Framework\Constraint\Constraint;

/**
 * File is owned by UID.
 */
final class HasUserId extends Constraint
{
    /** @var int */
    private $uid;

    public function __construct(int $uid)
    {
        $this->uid = $uid;
    }

    public function toString(): string
    {
        return 'file is owned by ' . $this->uid;
    }

    /**
     * @param string $file
     */
    protected function failureDescription($file): string
    {
        return sprintf('file "%s" is owned by %d', $file, $this->uid);
    }

    /**
     * @param string $file
     */
    protected function matches($file): bool
    {
        return fileowner($file) === $this->uid;
    }
}
