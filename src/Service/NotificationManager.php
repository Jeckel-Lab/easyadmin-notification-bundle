<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 19/12/2019
 */

namespace JeckelLab\NotificationBundle\Service;

use DateInterval;
use Exception;
use JeckelLab\NotificationBundle\Entity\Notification;
use JeckelLab\NotificationBundle\Repository\NotificationRepository;
use JeckelLab\NotificationBundle\ValueObject\NotificationLevel;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use JeckelLab\Clock\ClockInterface;

/**
 * Class NotificationService
 * @package App\Bundle\NotificationBundle\Service
 */
class NotificationManager
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
     * @param string                 $message
     * @param NotificationLevel|null $level
     * @return Notification
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function createNotification(string $message, ?NotificationLevel $level): Notification
    {
        return (new Notification())
            ->setMessage($message)
            ->setLevel($level ?: NotificationLevel::INFO());
    }

    /**
     * @param Notification $notification
     * @return Notification
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Notification $notification): Notification
    {
        if ($notification->getSendAt() === null) {
            $notification->setSendAt($this->clock->now());
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

    /**
     * @param array $ids
     * @return $this
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function batchMarkAsRead(array $ids): self
    {
        foreach ($ids as $id) {
            /** @var Notification|null $notification */
            $notification = $this->repository->find($id);
            if (null === $notification) {
                continue;
            }
            $this->markAsRead($notification);
        }
        return $this;
    }

    /**
     * @param int                    $nbDays
     * @param NotificationLevel|null $level
     * @return int
     * @throws Exception
     */
    public function removeObsolete(int $nbDays, ?NotificationLevel $level = null): int
    {
        return $this->repository->deleteOlderThan(
            $this->clock->now()
                ->sub(new DateInterval(sprintf('P%sD', $nbDays))),
            $level
        );
    }
}
