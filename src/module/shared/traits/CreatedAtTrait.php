<?php

namespace App\module\shared\traits;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

trait CreatedAtTrait
{
    /**
     * @Groups({"default"})
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     * @var ?DateTimeInterface
     */
    protected ?DateTimeInterface $createdAt;

    /**
     * Set createdAt
     * @ORM\PrePersist
     */
    public function setCreatedAt()
    {
        $this->createdAt  = new DateTime();

        if (property_exists($this, 'updatedAt')) {
            $this->updatedAt  = new DateTime();
        }
    }

    /**
     * Get createdAt
     * @return ?DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface|string
    {
        return $this->createdAt->format('Y-m-d H:i:s');
    }
}
