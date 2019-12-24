<?php

namespace JeckelLab\NotificationBundle\Repository;

use JeckelLab\NotificationBundle\Entity\Notification;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * @method Notification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notification[]    findAll()
 * @method Notification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationRepository extends ServiceEntityRepository
{
    /**
     * NotificationRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notification::class);
    }

    /**
     * @param Notification $notification
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Notification $notification): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($notification);
        $entityManager->flush();
    }

    /**
     * @return int
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countUnread(): int
    {
        return $this->createQueryBuilder('n')
            ->select('COUNT(n.notificationId)')
            ->andWhere('n.read_at IS NULL')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @param DateTimeInterface $dateTime
     */
    public function deleteOlderThan(DateTimeInterface $dateTime): void
    {
        $this->createQueryBuilder('n')
            ->delete()
            ->where('n.send_at < :date')
            ->setParameter('date', $dateTime)
            ->getQuery()
            ->execute();
    }
}
