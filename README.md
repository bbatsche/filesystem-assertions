# PHPUnit Filesystem Assertions

This is a small collection PHPUnit assertions for testing filesystem entries. It is meant to compliment the assertions already built into PHPunit.


## Table of Contents

- [Installation](#installation)
- [Available Assertions](#available-assertions)

## Installation

Use Composer to install the current version of PHPUnit Filesystem Asserts from [Packagist](https://packagist.org/packages/bebat/phpunit-filesystem-assert).

```bash
composer require --dev bebat/filesystem-assertions
```

The easiest way to add these assertions to your test case(s) is using a trait:

```php
<?php

use BeBat\FilesystemAssertions\FilesystemAssertionsTrait;
use PHPUnit\Framework\TestCase;

class SomeTest extends TestCase
{
    use FilesystemAssertionsTrait;

    // ...
}
```

## Available Assertions

```php
// Assert that a filesystem entry exists.
// These assertions only check if a path is a normal file, directory, or symbolic link.
// They aren't compatible with block devices, sockets, or other nonstandard file types.
assertFsEntryExists(string $file, string $message = '')
assertFsEntryDoesNotExist(string $file, string $message = '')

// Assert that $directory contains one or more files.
assertDirectoryContainsFiles(string $directory, array $files, string $message = '');
assertDirectoryDoesNotContainFiles(string $directory, array $files, string $message = '')

// Assert that $file is owned by a user ID or name.
assertFileHasUserId(string $file, int $uid, string $message = '')
assertFileHasUser(string $file, string $user, string $message = '')
assertFileDoesNotHaveUserId(string $file, int $uid, string $message = '')
assertFileDoesNotHaveUser(string $file, string $user, string $message = '')

// Assert that $file has a group ID or name.
assertFileHasGroupId(string $file, int $gid, string $message = '')
assertFileHasGroup(string $file, string $group, string $message = '')
assertFileDoesNotHaveGroupId(string $file, int $gid, string $message = '')
assertFileDoesNotHaveGroup(string $file, string $group, string $message = '')

// Assert that $file is executable.
assertFileIsExecutable(string $file, string $message = '')
assertFileIsNotExecutable(string $file, string $message = '')

// Assert that $file is a symbolic link.
assertFileIsLink(string $file, string $message = '')
assertFileIsNotLink(string $file, string $message = '')

// Assert that $file is a symbolic link and points to $target.
assertSymbolicLinkPointsTo(string $file, string $target, string $message = '')
assertSymbolicLinkDoesNotPointTo(string $file, string $target, string $message = '')

// Assert that $file's permissions are exactly an octal string (or integer).
assertFilePermissionsEqual(string $file, $perms, string $message = '')
assertFilePermissionsDoNotEqual(string $file, $perms, string $message = '')

// Assert that $file's permissions MATCH an octal string (or integer).
// For example, if a file has permissions 755, 644 would match but 422 would NOT.
assertFilePermissionsMatch(string $file, $perms, string $message = '')
assertFilePermissionsDoNotMatch(string $file, $perms, string $message = '')
```
