<?php

declare(strict_types=1);

namespace BeBat\FilesystemAssertions;

use BeBat\FilesystemAssertions\Constraint\DirectoryContains;
use BeBat\FilesystemAssertions\Constraint\HasGroup;
use BeBat\FilesystemAssertions\Constraint\HasGroupId;
use BeBat\FilesystemAssertions\Constraint\HasLinkTarget;
use BeBat\FilesystemAssertions\Constraint\HasUser;
use BeBat\FilesystemAssertions\Constraint\HasUserId;
use BeBat\FilesystemAssertions\Constraint\IsExecutable;
use BeBat\FilesystemAssertions\Constraint\IsFile;
use BeBat\FilesystemAssertions\Constraint\IsLink;
use BeBat\FilesystemAssertions\Constraint\PermsEqual;
use BeBat\FilesystemAssertions\Constraint\PermsMatch;
use PHPUnit\Framework\Assert;

/**
 * A collections of assertions for filesystem objects.
 */
trait FilesystemAssertionsTrait
{
    /**
     * Assert that a directory contains one or more files.
     *
     * @param string[] $files
     */
    public static function assertDirectoryContainsFiles(string $directory, array $files, string $message = ''): void
    {
        Assert::assertDirectoryExists($directory, $message);

        Assert::assertThat($directory, new DirectoryContains($files), $message);
    }

    /**
     * Assert that a files are not present in a directory.
     *
     * @param string[] $files
     */
    public static function assertDirectoryDoesNotContainFiles(string $directory, array $files, string $message = ''): void
    {
        Assert::assertDirectoryExists($directory, $message);

        Assert::assertThat($directory, Assert::logicalNot(new DirectoryContains($files)), $message);
    }

    /**
     * Assert that a file is not assigned to a group name.
     */
    public static function assertFileDoesNotHaveGroup(string $file, string $group, string $message = ''): void
    {
        Assert::assertFileExists($file, $message);

        Assert::assertThat($file, Assert::logicalNot(new HasGroup($group)), $message);
    }

    /**
     * Assert that a file is not assigned to a group ID (GID).
     */
    public static function assertFileDoesNotHaveGroupId(string $file, int $gid, string $message = ''): void
    {
        Assert::assertFileExists($file, $message);

        Assert::assertThat($file, Assert::logicalNot(new HasGroupId($gid)), $message);
    }

    /**
     * Assert that a file is not owned by a certain user name.
     */
    public static function assertFileDoesNotHaveUser(string $file, string $user, string $message = ''): void
    {
        Assert::assertFileExists($file, $message);

        Assert::assertThat($file, Assert::logicalNot(new HasUser($user)), $message);
    }

    /**
     * Assert that a file is not owned by a certain user ID (UID).
     */
    public static function assertFileDoesNotHaveUserId(string $file, int $uid, string $message = ''): void
    {
        Assert::assertFileExists($file, $message);

        Assert::assertThat($file, Assert::logicalNot(new HasUserId($uid)), $message);
    }

    /**
     * Assert that a file has a certain group name assigned.
     */
    public static function assertFileHasGroup(string $file, string $group, string $message = ''): void
    {
        Assert::assertFileExists($file, $message);

        Assert::assertThat($file, new HasGroup($group), $message);
    }

    /**
     * Assert that a file has a certain group ID (GID) assigned.
     */
    public static function assertFileHasGroupId(string $file, int $gid, string $message = ''): void
    {
        Assert::assertFileExists($file, $message);

        Assert::assertThat($file, new HasGroupId($gid), $message);
    }

    /**
     * Assert that a file is owned by a certain user name.
     */
    public static function assertFileHasUser(string $file, string $user, string $message = ''): void
    {
        Assert::assertFileExists($file, $message);

        Assert::assertThat($file, new HasUser($user), $message);
    }

    /**
     * Assert that a file is owned by a certain user ID (UID).
     */
    public static function assertFileHasUserId(string $file, int $uid, string $message = ''): void
    {
        Assert::assertFileExists($file, $message);

        Assert::assertThat($file, new HasUserId($uid), $message);
    }

    /**
     * Assert that a file is executable.
     */
    public static function assertFileIsExecutable(string $file, string $message = ''): void
    {
        Assert::assertFileExists($file, $message);

        Assert::assertThat($file, new IsExecutable(), $message);
    }

    /**
     * Assert that a file is a symbolic link.
     */
    public static function assertFileIsLink(string $file, string $message = ''): void
    {
        Assert::assertThat($file, new IsLink(), $message);
    }

    /**
     * Assert that a file is not executable.
     */
    public static function assertFileIsNotExecutable(string $file, string $message = ''): void
    {
        Assert::assertFileExists($file, $message);

        Assert::assertThat($file, Assert::logicalNot(new IsExecutable()), $message);
    }

    /**
     * Assert that a file is not a symbolic link.
     */
    public static function assertFileIsNotLink(string $file, string $message = ''): void
    {
        Assert::assertThat($file, Assert::logicalNot(new IsLink()), $message);
    }

    /**
     * Assert that a file permissions are not equal to a given octal string or integer.
     *
     * @param int|string $perms octal permissions as either a string or int
     */
    public static function assertFilePermissionsDoNotEqual(string $file, $perms, string $message = ''): void
    {
        if (\is_int($perms)) {
            $perms = decoct($perms);
        }

        Assert::assertFileExists($file, $message);

        Assert::assertThat($file, Assert::logicalNot(new PermsEqual($perms)), $message);
    }

    /**
     * Assert that a file's permissions do not match an octal string or integer.
     *
     * @param int|string $perms octal permissions as either a string or int
     */
    public static function assertFilePermissionsDoNotMatch(string $file, $perms, string $message = ''): void
    {
        if (\is_string($perms)) {
            $perms = (int) octdec($perms);
        }

        Assert::assertFileExists($file, $message);

        Assert::assertThat($file, Assert::logicalNot(new PermsMatch($perms)), $message);
    }

    /**
     * Assert that a file permissions are equal to a given octal string or integer.
     *
     * @param int|string $perms octal permissions as either a string or int
     */
    public static function assertFilePermissionsEqual(string $file, $perms, string $message = ''): void
    {
        if (\is_int($perms)) {
            $perms = decoct($perms);
        }

        Assert::assertFileExists($file, $message);

        Assert::assertThat($file, new PermsEqual($perms), $message);
    }

    /**
     * Assert that a file's permissions match (but don't necessarily equal) an octal string or integer.
     *
     * For example, if a file's permissions were 755, 644 would pass but 422 would not.
     *
     * @param int|string $perms octal permissions as either a string or int
     */
    public static function assertFilePermissionsMatch(string $file, $perms, string $message = ''): void
    {
        if (\is_string($perms)) {
            $perms = (int) octdec($perms);
        }

        Assert::assertFileExists($file, $message);

        Assert::assertThat($file, new PermsMatch($perms), $message);
    }

    /**
     * Assert $path is a regular file.
     */
    public static function assertIsFile(string $path, string $message = ''): void
    {
        Assert::assertThat($path, new IsFile(), $message);
    }

    /**
     * Assert $path is not a regular file.
     */
    public static function assertIsNotFile(string $path, string $message = ''): void
    {
        Assert::assertThat($path, Assert::logicalNot(new IsFile()), $message);
    }

    /**
     * Assert that a symbolic link does not point to a particular file.
     */
    public static function assertSymbolicLinkDoesNotPointTo(string $file, string $target, string $message = ''): void
    {
        static::assertFileIsLink($file, $message);

        Assert::assertThat($file, Assert::logicalNot(new HasLinkTarget($target)), $message);
    }

    /**
     * Assert that a symbolic link points to a particular file.
     */
    public static function assertSymbolicLinkPointsTo(string $file, string $target, string $message = ''): void
    {
        static::assertFileIsLink($file, $message);

        Assert::assertThat($file, new HasLinkTarget($target), $message);
    }
}
