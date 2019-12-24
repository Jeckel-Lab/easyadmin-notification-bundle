<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 24/12/2019
 */

namespace JeckelLab\NotificationBundle;

use JeckelLab\NotificationBundle\DependencyInjection\NotificationBundleExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class JeckelLabNotificationBundle
 * @package JeckelLab\NotificationBundle
 */
class JeckelLabNotificationBundle extends Bundle
{
    /**
     * @return NotificationBundleExtension|ExtensionInterface|null
     */
    public function getContainerExtension()
    {
        return new NotificationBundleExtension();
    }
}
