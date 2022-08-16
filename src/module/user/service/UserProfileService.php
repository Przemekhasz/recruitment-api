<?php

declare(strict_types=1);

namespace App\module\user\service;

use App\module\user\dto\request\CreateUserProfileRequestTObject;
use App\module\user\entity\User;
use App\module\user\repository\UserRepository;
use InvalidArgumentException;

class UserProfileService
{
    private  UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param User $currentUser
     * @param CreateUserProfileRequestTObject $dto
     * @return User
     */
    public function create(User $currentUser, CreateUserProfileRequestTObject $dto)
    {
        if (empty($dto->firstName) || strlen($dto->firstName) < 3) {
            throw new InvalidArgumentException("First Name is not acceptable");
        }
        if (empty($dto->lastName)  || strlen($dto->lastName) < 2) {
            throw new InvalidArgumentException("Last Name is not acceptable");
        }

        $currentUser
            ->setFirstName($dto->firstName)
            ->setLastName($dto->lastName)
            ->setUpdatedAt();

        $this->userRepository->update($currentUser);
        return $currentUser;
    }
}