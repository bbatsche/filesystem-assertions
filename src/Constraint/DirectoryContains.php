<?php

declare(strict_types=1);

namespace BeBat\FilesystemAssert\Constraint;

use PHPUnit\Framework\Constraint\Constraint;

/**
 * Directory contains a list of files.
 */
final class DirectoryContains extends Constraint
{
    /** @var string[] */
    private $files;

    /**
     * @param string[] $files
     */
    public function __construct(array $files)
    {
        $this->files = $files;

        sort($this->files);
    }

    public function toString(): string
    {
        return sprintf('directory contains "%s"', implode(', ', $this->files));
    }

    /**
     * @param string $directory
     */
    protected function failureDescription($directory): string
    {
        return sprintf('directory "%s" contains "%s"', $directory, implode(', ', $this->files));
    }

    /**
     * @param string $directory
     */
    protected function matches($directory): bool
    {
        $files = (array) scandir($directory);

        return array_values(array_intersect($files, $this->files)) === $this->files;
    }
}
