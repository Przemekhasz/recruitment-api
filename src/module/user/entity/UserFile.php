<?php

declare(strict_types=1);

namespace App\module\user\entity;

use App\module\shared\traits\CreatedAtTrait;
use App\module\shared\traits\UUIDTrait;
use Doctrine\ORM\Mapping as ORM;
use App\module\user\repository\UserFileRepository;

/**
 * @ORM\Entity(repositoryClass=UserFileRepository::class)
 * @ORM\Table(name="user_file")
 */
class UserFile
{
    use UUIDTrait;
    use CreatedAtTrait;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private string $fileName;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    private float $fileSize;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private string $fileDir;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private string $fileURL;

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     * @return UserFile
     */
    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;
        return $this;
    }

    /**
     * @return float
     */
    public function getFileSize(): float
    {
        return $this->fileSize;
    }

    /**
     * @param float $fileSize
     * @return UserFile
     */
    public function setFileSize(float $fileSize): self
    {
        $this->fileSize = $fileSize;
        return $this;
    }

    /**
     * @return string
     */
    public function getFileDir(): string
    {
        return $this->fileDir;
    }

    /**
     * @param string $fileDir
     * @return UserFile
     */
    public function setFileDir(string $fileDir): self
    {
        $this->fileDir = $fileDir;
        return $this;
    }

    /**
     * @return string
     */
    public function getFileURL(): string
    {
        return $this->fileURL;
    }

    /**
     * @param string $fileURL
     * @return UserFile
     */
    public function setFileURL(string $fileURL): self
    {
        $this->fileURL = $fileURL;
        return $this;
    }
}