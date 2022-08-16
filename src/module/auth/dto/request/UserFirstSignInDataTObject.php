<?php

declare(strict_types=1);

namespace App\module\auth\dto\request;

use App\kernel\sharedKernel\helper\DTOHelper\DTOHelper;

class UserFirstSignInDataTObject extends DTOHelper
{
    public string $firstName = "";
    public string $lastName = "";

    public function __construct($request)
    {
        $this->assignJsonToProperties($this, $request);
    }
}