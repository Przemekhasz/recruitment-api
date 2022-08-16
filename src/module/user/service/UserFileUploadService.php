<?php

declare(strict_types=1);

namespace App\module\user\service;

use App\module\user\command\UserFileUploadCommand;
use App\module\user\dto\request\CreateUserProfileRequestTObject;
use App\module\user\entity\User;
use App\module\user\repository\UserRepository;
use App\module\user\resolver\FileExtensionResolver;
use App\module\user\resolver\FileSizeResolver;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;

class UserFileUploadService
{
    private  UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param User $currentUser
     * @param FileBag $files
     * @return User
     */
    public function upload(User $currentUser, FileBag $files): User
    {
        if ($files->count() === 0) {
            throw new InvalidArgumentException('Files variable cant be empty');
        }

        foreach ($files as $filesArr)
        {
            foreach ($filesArr as $file)
            {
                if (!$file instanceof UploadedFile) continue;
                FileExtensionResolver::Resolve($file);
                FileSizeResolver::Resolve($file);
                UserFileUploadCommand::Execute($currentUser, $file);
            }
        }

        $this->userRepository->update($currentUser);
        return $currentUser;
    }
}