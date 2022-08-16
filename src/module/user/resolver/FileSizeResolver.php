<?php

declare(strict_types=1);

namespace App\module\user\resolver;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileSizeResolver
{
    const MAX_FILE_SIZE = 5242880; // in bytes (5MB)

    public static function Resolve(UploadedFile $file): bool
    {
        if ($file->getSize() > FileSizeResolver::MAX_FILE_SIZE) {
            throw new \InvalidArgumentException("File cant be higher than 5MB");
        }
        return true;
    }
}