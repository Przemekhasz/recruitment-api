<?php

declare(strict_types=1);

namespace App\module\user\command;

use App\module\user\entity\User;
use App\module\user\entity\UserFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserFileUploadCommand
{
    public static function Execute(User &$currentUser, UploadedFile $file): User
    {
        $fileNewName = sprintf("%s.%s", md5(microtime()), $file->guessClientExtension());
        $fileNewDir = sprintf("storage/%s", $fileNewName);
        $fileNewUrl = sprintf("%s/storage/%s",$_SERVER['SERVER_NAME'], $fileNewName);

        $file->move("storage/", $fileNewName);

        $userFile = new UserFile();
        $userFile
            ->setFileName($fileNewName)
            ->setFileDir($fileNewDir)
            ->setFileSize(filesize($fileNewDir))
            ->setFileURL($fileNewUrl)
            ->setCreatedAt();

        $currentUser->addFile($userFile);
        return $currentUser;
    }
}