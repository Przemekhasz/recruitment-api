<?php

declare(strict_types=1);

namespace App\module\auth\service;

use App\module\auth\dto\request\UserSIgnInDataTObject;
use App\module\auth\dto\request\UserSignUpDataTObject;
use App\module\auth\exception\WrongCredentialsException;
use App\module\auth\resolver\PasswordPolicyResolver;
use App\module\user\entity\User;
use App\module\user\exception\UserAlreadyExistsException;
use App\module\user\repository\UserRepository;
use Exception;
use InvalidArgumentException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class AuthService
{
    private UserRepository $userRepository;

    private JWTTokenManagerInterface $tokenManager;
    /**
     * @throws Exception
     */
    public function __construct(
        UserRepository $userRepository,
        JWTTokenManagerInterface $tokenManager
    )
    {
        $this->userRepository = $userRepository;
        $this->tokenManager = $tokenManager;
    }


    /**
     * @throws UserAlreadyExistsException
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function signUp(UserSignUpDataTObject $dto): User
    {
        PasswordPolicyResolver::Resolve($dto->password);

        if (!filter_var($dto->email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Please provide correct Email format");
        }

        if ($this->userRepository->exists($dto->email)) {
            throw new UserAlreadyExistsException("User with provided email already exists");
        }

        $user = new User();
        $user
            ->setEmail($dto->email)
            ->hashPassword($dto->password)
            ->setCreatedAt();

        $this->userRepository->create($user);

        return $this->applyJWT($user);
    }

    /**
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function signIn(UserSIgnInDataTObject $dto): User
    {
        PasswordPolicyResolver::Resolve($dto->password);
        if (!filter_var($dto->email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Please provide correct Email format");
        }

        $user = $this->userRepository->findByEmail($dto->email);

        if (!password_verify($dto->password, $user->getPassword())) {
            throw new WrongCredentialsException("Invalid E-mail or Password");
        }

        return $this->applyJWT($user);
    }

    public function applyJWT(User &$user): User {

        $token = $this->tokenManager->create($user);
        return $user->setJwt((string)$token);
    }
}