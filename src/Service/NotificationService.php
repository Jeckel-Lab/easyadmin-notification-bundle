<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 19/12/2019
 */

namespace JeckelLab\NotificationBundle\Service;

use JeckelLab\NotificationBundle\Entity\Notification;
use JeckelLab\NotificationBundle\Repository\NotificationRepository;
use JeckelLab\NotificationBundle\ValueObject\NotificationLevel;
use DateTimeInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use JeckelLab\Clock\ClockInterface;

/**
 * Class NotificationService
 * @package App\Bundle\NotificationBundle\Service
 */
class NotificationService
{
    /** @var NotificationRepository */
    protected $repository;

    /** @var ClockInterface */
    protected $clock;

    /**
     * NotificationService constructor.
     * @param NotificationRepository $repository
     * @param ClockInterface         $clock
     */
    public function __construct(NotificationRepository $repository, ClockInterface $clock)
    {
        $this->repository = $repository;
        $this->clock = $clock;
    }

    /**
     * @param NotificationLevel      $level
     * @param string                 $message
     * @param string|null            $source
     * @param DateTimeInterface|null $sendAt
     * @return Notification
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function addNotification(
        NotificationLevel $level,
        string $message,
        ?string $source = null,
        ?DateTimeInterface $sendAt = null
    ) : Notification {
        $notification = (new Notification())
            ->setLevel($level)
            ->setMessage($message)
            ->setSendAt($sendAt?: $this->clock->now());

        if (null !== $source) {
            $notification->setSource($source);
        }

        $this->repository->save($notification);
        return $notification;
    }

    /**
     * @param Notification $notification
     * @return Notification
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function markAsRead(Notification $notification): Notification
    {
        $notification->markRead($this->clock->now());
        $this->repository->save($notification);
        return $notification;
    }
}
