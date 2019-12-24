<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 25/11/2019
 */

namespace JeckelLab\NotificationBundle\EventListener;

use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use JeckelLab\NotificationBundle\Entity\Notification;
use JeckelLab\NotificationBundle\Event\NotificationEventInterface;
use JeckelLab\NotificationBundle\Service\NotificationManager;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Class NotificationEventListener
 * @package App\Bundle\NotificationBundle\EventListener
 */
class NotificationEventListener
{
    /** @var NotificationManager */
    protected $notificationManager;

    /**
     * NotificationEventListener constructor.
     * @param NotificationManager $notificationManager
     */
    public function __construct(NotificationManager $notificationManager)
    {
        $this->notificationManager = $notificationManager;
    }

    /**
     * @param NotificationEventInterface $event
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function onNotificationEvent($event): void
    {
        if (! $event instanceof NotificationEventInterface) {
            return;
        }

        $this->notificationManager->save(
            $this->notificationManager->createNotification($event->getMessage(), $event->getLevel())
                ->setSource($event->getSource())
                ->setSendAt($event->getSendAt())
        );
    }

    /**
     * @param GenericEvent $event
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function onEasyAdminShow(GenericEvent $event): void
    {
        $notification = $event->getSubject();
        if (! $notification instanceof Notification) {
            return;
        }
        $this->notificationManager->markAsRead($notification);
    }
}
