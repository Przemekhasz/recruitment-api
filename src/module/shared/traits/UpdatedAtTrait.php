<?php

namespace App\module\shared\traits;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

trait UpdatedAtTrait
{
    /**
     * @Groups({"default"})
     * @ORM\Column(type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     * @var DateTimeInterface
     */
    private DateTimeInterface $updatedAt;

    /**
     * Set updatedAt
     * @ORM\PreUpdate
     */
    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * Get updatedAt
     *
     * @return DateTimeInterface|string
     */
    public function getUpdatedAt(): DateTimeInterface|string
    {
        return $this->updatedAt->format('Y-m-d H:i:s');
    }
}
