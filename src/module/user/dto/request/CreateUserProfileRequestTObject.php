<?php

declare(strict_types=1);

namespace App\module\user\dto\request;

use App\kernel\sharedKernel\helper\DTOHelper\DTOHelper;

class CreateUserProfileRequestTObject extends DTOHelper
{
    public string $firstName = "";
    public string $lastName = "";

    public function __construct($request)
    {
        $this->assignJsonToProperties($this, $request);
    }
}