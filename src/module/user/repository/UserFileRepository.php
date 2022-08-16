<?php

declare(strict_types=1);

namespace App\module\user\repository;

use App\module\shared\interfaces\IRepository;
use App\module\user\entity\User;
use App\module\user\entity\UserFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

class UserFileRepository extends ServiceEntityRepository implements IRepository
{
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, UserFile::class);
    }

    public function create($entity): void
    {
        if (!($entity instanceof UserFile)) return;

        $this->_em->persist($entity);
        $this->_em->flush();
    }

    public function update($entity):void
    {
        if (!($entity instanceof UserFile)) return;
        $this->_em->flush();
    }

    /**
     * @param $entity
     *
     */
    public function delete($entity):void
    {
        if (!($entity instanceof UserFile)) return;

        $this->_em->remove($entity);
        $this->_em->flush();
    }
}