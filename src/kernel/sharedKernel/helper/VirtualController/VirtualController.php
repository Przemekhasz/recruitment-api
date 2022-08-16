<?php

declare(strict_types=1);

namespace App\kernel\sharedKernel\helper\VirtualController;

use App\module\user\entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class VirtualController extends AbstractController
{
    /**
     * @return User
     */
    public function user(): User
    {
        $user = $this->getUser();
        if ($user instanceof User) {
            return $user;
        }
        return new User();
    }
}
