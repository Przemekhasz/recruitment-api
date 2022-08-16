<?php

declare(strict_types=1);

namespace App\module\auth\dto\request;

use App\kernel\sharedKernel\helper\DTOHelper\DTOHelper;

class UserSIgnInDataTObject extends DTOHelper
{
    public string $email = "";
    public string $password = "";

    public function __construct($request)
    {
        $this->assignJsonToProperties($this, $request);
    }
}