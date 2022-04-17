<?php

declare(strict_types=1);

namespace BeBat\FilesystemAssert\Constraint;

use PHPUnit\Framework\Constraint\Constraint;

/**
 * File is owned by username.
 */
final class HasUser extends Constraint
{
    /** @var string */
    private $user;

    public function __construct(string $user)
    {
        $this->user = $user;
    }

    public function toString(): string
    {
        return sprintf('file is owned by "%s"', $this->user);
    }

    /**
     * @param string $file
     */
    protected function failureDescription($file): string
    {
        return sprintf('file "%s" is owned by "%s"', $file, $this->user);
    }

    /**
     * @param string $file
     */
    protected function matches($file): bool
    {
        $ownerId = fileowner($file);

        if ($ownerId === false) {
            return false;
        }

        $userInfo = posix_getpwuid($ownerId);

        return \is_array($userInfo) && $userInfo['name'] === $this->user;
    }
}
