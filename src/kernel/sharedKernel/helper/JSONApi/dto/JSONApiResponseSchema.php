<?php

declare(strict_types=1);

namespace App\kernel\sharedKernel\helper\JSONApi\dto;

use stdClass;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;

class JSONApiResponseSchema
{
    /**
     * @Groups({"default"})
     * @var string
     */
    public string $type = '';
    
    /**
     * @Groups({"default"})
     * @var int
     */
    public int $status = 200;
    
    
    /**
     * @Groups({"default"})
     * @var string
     */
    public string $message = '';
    
    
    /**
     * @Groups({"default"})
     * @var mixed
     */
    public $data = null;
    
    
    /**
     * @Ignore()
     * @var array
     */
    public array $groups = [];
    
    
    /**
     * @Ignore()
     * @var array
     */
    public array $ignore = [];

    public function cleanUp() {
        $this->status = 200;
        $this->message = '';
        $this->data = null;
        $this->groups = [];
    }
}
