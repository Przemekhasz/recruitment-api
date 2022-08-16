<?php

declare(strict_types=1);

namespace App\module\auth\resolver;

use Exception;
use InvalidArgumentException;

class PasswordPolicyResolver
{
    /**
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public static function Resolve(string $password): void
    {
        if (!isset($_ENV['PASSWORD_MIN_LENGTH'])) {
            throw new Exception("PASSWORD_MIN_LENGTH is not configured");
        }

        if (strlen($password) < (int)$_ENV['PASSWORD_MIN_LENGTH']) {
            throw new InvalidArgumentException("Password length cant be less than ".(int)$_ENV['PASSWORD_MIN_LENGTH']);
        }
    }
}