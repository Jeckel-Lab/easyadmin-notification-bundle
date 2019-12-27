<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 25/11/2019
 */

namespace JeckelLab\NotificationBundle\Controller;

use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use JeckelLab\NotificationBundle\Service\NotificationManager;

/**
 * Class NotificationController
 * @package JeckelLab\NotificationBundle\Controller
 */
class NotificationController extends EasyAdminController
{
    /** @var NotificationManager */
    protected $notificationManager;

    /**
     * NotificationController constructor.
     * @param NotificationManager $notificationManager
     */
    public function __construct(NotificationManager $notificationManager)
    {
        $this->notificationManager = $notificationManager;
    }

    /**
     * @param array $ids
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function markReadBatchAction(array $ids): void
    {
        $this->notificationManager->batchMarkAsRead($ids);
    }
}
