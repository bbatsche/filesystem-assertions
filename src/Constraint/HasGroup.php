<?php

declare(strict_types=1);

namespace BeBat\FilesystemAssert\Constraint;

use PHPUnit\Framework\Constraint\Constraint;

/**
 * File belongs to group name.
 */
final class HasGroup extends Constraint
{
    /** @var string */
    private $group;

    public function __construct(string $group)
    {
        $this->group = $group;
    }

    public function toString(): string
    {
        return sprintf('file belongs to group "%s"', $this->group);
    }

    /**
     * @param string $file
     */
    protected function failureDescription($file): string
    {
        return sprintf('file "%s" belongs to group "%s"', $file, $this->group);
    }

    /**
     * @param string $file
     */
    protected function matches($file): bool
    {
        $groupId = filegroup($file);

        if ($groupId === false) {
            return false;
        }

        $groupInfo = posix_getgrgid($groupId);

        return \is_array($groupInfo) && $groupInfo['name'] === $this->group;
    }
}
