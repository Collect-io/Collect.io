<?php

declare(strict_types=1);

namespace App\EnhancedFlysystemAdapter;

use League\Flysystem\AdapterInterface;

interface EnhancedFlysystemAdapterInterface extends AdapterInterface
{
    /**
     * Rename a directory.
     *
     * @param string $path
     * @param string $newPath
     *
     * @return bool
     */
    public function renameDir(string $path, string $newPath): bool;
}
