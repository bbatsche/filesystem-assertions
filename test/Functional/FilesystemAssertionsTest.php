<?php

declare(strict_types=1);

namespace BeBat\FilesystemAssertions\Test\Functional;

use BeBat\FilesystemAssertions\FilesystemAssertionsTrait;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class FilesystemAssertionsTest extends TestCase
{
    use FilesystemAssertionsTrait;

    /** @var string */
    protected const FIXTURE_DIR = __DIR__ . '/_fixtures';

    public function testDirectoryContainsFiles(): void
    {
        self::assertDirectoryContainsFiles(self::FIXTURE_DIR, ['File1', 'File2']);
        self::assertDirectoryDoesNotContainFiles(self::FIXTURE_DIR, ['File2', 'File4']);
    }

    public function testExecutable(): void
    {
        self::assertFileIsExecutable(self::FIXTURE_DIR);
        self::assertFileIsExecutable(self::FIXTURE_DIR . '/File1');

        self::assertFileIsNotExecutable(self::FIXTURE_DIR . '/File2');
    }

    public function testFileGroup(): void
    {
        // we assume the same user & group owns the entire repo
        $gid = (int) filegroup(__FILE__);

        self::assertFileHasGroupId(self::FIXTURE_DIR, $gid);
        self::assertFileHasGroupId(self::FIXTURE_DIR . '/File1', $gid);
        self::assertFileHasGroupId(self::FIXTURE_DIR . '/File3', $gid);

        $groupInfo = posix_getgrgid($gid);

        if (!\is_array($groupInfo)) {
            self::markTestIncomplete('Could not get POSIX group info for testing.');
        }

        $groupName = $groupInfo['name'];

        self::assertFileHasGroup(self::FIXTURE_DIR, $groupName);
        self::assertFileHasGroup(self::FIXTURE_DIR . '/File1', $groupName);
        self::assertFileHasGroup(self::FIXTURE_DIR . '/File3', $groupName);
    }

    public function testFilePermissions(): void
    {
        // we cannot be sure of exact permissions but we can at least match some known values
        self::assertFilePermissionsMatch(self::FIXTURE_DIR, (int) octdec('700'));
        self::assertFilePermissionsMatch(self::FIXTURE_DIR . '/File1', '700');
        self::assertFilePermissionsMatch(self::FIXTURE_DIR . '/File2', (int) octdec('600'));
        self::assertFilePermissionsDoNotMatch(self::FIXTURE_DIR . '/File2', '755');
    }

    public function testFileUser(): void
    {
        // we assume the same user & group owns the entire repo
        $uid = (int) fileowner(__FILE__);

        self::assertFileHasUserId(self::FIXTURE_DIR, $uid);
        self::assertFileHasUserId(self::FIXTURE_DIR . '/File1', $uid);
        self::assertFileHasUserId(self::FIXTURE_DIR . '/File3', $uid);

        $userInfo = posix_getpwuid($uid);

        if (!\is_array($userInfo)) {
            self::markTestIncomplete('Could not get POSIX group info for testing.');
        }

        $userName = $userInfo['name'];

        self::assertFileHasUser(self::FIXTURE_DIR, $userName);
        self::assertFileHasUser(self::FIXTURE_DIR . '/File1', $userName);
        self::assertFileHasUser(self::FIXTURE_DIR . '/File3', $userName);
    }

    public function testIsFile(): void
    {
        self::assertIsFile(self::FIXTURE_DIR . '/File1');
        self::assertIsNotFile(self::FIXTURE_DIR);
        self::assertIsNotFile(self::FIXTURE_DIR . '/File4');
    }

    public function testSymbolicLink(): void
    {
        self::assertFileIsLink(self::FIXTURE_DIR . '/File3');
        self::assertFileIsNotLink(self::FIXTURE_DIR . '/File2');
        self::assertSymbolicLinkPointsTo(self::FIXTURE_DIR . '/File3', 'File2');
        self::assertSymbolicLinkDoesNotPointTo(self::FIXTURE_DIR . '/File3', 'File1');
    }
}
