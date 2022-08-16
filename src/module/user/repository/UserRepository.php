<?php

declare(strict_types=1);

namespace App\module\user\repository;

use App\module\shared\interfaces\IRepository;
use App\module\user\entity\User;
use App\module\user\entity\UserFile;
use App\module\user\exception\UserNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

class UserRepository extends ServiceEntityRepository implements IRepository
{
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, User::class);
    }

    /**
     * @param string $email
     * @return bool
     */
    public function exists(string $email): bool {
        try {
            return strlen($this->findByEmail($email)->getId()) > 0;
        } catch (UserNotFoundException $e) {
            return false;
        }
    }

    /**
     * @param string $email
     *
     * @return User
     */
    public function findByEmail(string $email): User {
        try {
            return $this->createQueryBuilder('u')
                ->andWhere('u.email = :email')
                ->setParameter('email', $email)
                ->getQuery()
                ->getSingleResult(AbstractQuery::HYDRATE_OBJECT);
        }
        catch (Exception $e) {
            return throw new UserNotFoundException('User not found');
        }
    }

    public function create($entity): void
    {
        if (!($entity instanceof User)) return;

        $this->_em->persist($entity);
        $this->_em->flush();
    }

    public function update($entity):void
    {
        if (!($entity instanceof User)) return;
        $this->_em->flush();
    }

    /**
     * @param $entity
     *
     */
    public function delete($entity):void
    {
        if (!($entity instanceof User)) return;

        $this->_em->remove($entity);
        $this->_em->flush();
    }
}