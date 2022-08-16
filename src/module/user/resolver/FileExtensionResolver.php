<?php

declare(strict_types=1);

namespace App\module\user\resolver;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileExtensionResolver
{
    /**
     * @param UploadedFile $file
     * @return bool
     * @throws \InvalidArgumentException
     */
    public static function Resolve(UploadedFile $file): bool
    {
        switch ($file->guessClientExtension())
        {
            case "jpg":
            case "png":
            case "gif":
            case "bmp":
            case "pdf":
            case "docx":
            case "xlsx":
                return true;
            default:
                throw new \InvalidArgumentException("Provided file type is not allowed");
        }
    }
}