<?php

declare(strict_types=1);

namespace BeBat\FilesystemAssertions\Dev;

use PHPUnit\Runner\Version;

/**
 * Dynamically create phpunit.xml based on the currently installed version.
 *
 * @internal
 */
final class GeneratePhpUnitConfig
{
    /**
     * Create symbolic link to current version of phpunit.xml.
     */
    public static function execute(): void
    {
        $phpUnitVersion = (int) explode('.', Version::id())[0];
        $projectRoot    = \dirname(__DIR__);
        $versionConfig  = __DIR__ . "/phpunit{$phpUnitVersion}.xml";
        $configPath     = $projectRoot . '/phpunit.xml';

        if (file_exists($configPath)) {
            if (!is_link($configPath)) {
                // User has their own config, do not modify it
                return;
            }

            unlink($configPath);
        }

        if (file_exists($versionConfig)) {
            symlink($versionConfig, $configPath);
        }
    }
}
