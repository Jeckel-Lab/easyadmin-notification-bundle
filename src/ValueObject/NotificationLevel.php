<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 25/11/2019
 */

namespace JeckelLab\NotificationBundle\ValueObject;

use JeckelLab\AdvancedTypes\Enum\EnumAbstract;

/**
 * Class NotificationLevel
 * @package App\ValueObject
 * @method static NotificationLevel SUCCESS();
 * @method static NotificationLevel INFO();
 * @method static NotificationLevel WARNING();
 * @method static NotificationLevel DANGER();
 */
class NotificationLevel extends EnumAbstract
{
    public const SUCCESS = 'success';
    public const INFO    = 'info';
    public const WARNING = 'warning';
    public const DANGER  = 'danger';

    /**
     * @return string
     */
    public function __toString(): string
    {
        $value = $this->getValue();
        if (is_string($value)) {
            return $value;
        }
        return parent::__toString();
    }
}
