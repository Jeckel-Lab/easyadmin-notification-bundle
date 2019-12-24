<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 28/11/2019
 */

namespace JeckelLab\NotificationBundle\Event;

use JeckelLab\NotificationBundle\ValueObject\NotificationLevel;
use DateTimeInterface;

/**
 * Class NotificationEvent
 * @package App\Bundle\NotificationBundle\Event
 */
class NotificationEvent implements NotificationEventInterface
{
    use NotificationEventTrait;

    /**
     * NotificationEvent constructor.
     * @param NotificationLevel      $level
     * @param string                 $message
     * @param string|null            $source
     * @param DateTimeInterface|null $sendAt
     */
    public function __construct(
        NotificationLevel $level,
        string $message,
        ?string $source = null,
        ?DateTimeInterface $sendAt = null
    ) {
        $this->level = $level;
        $this->message = $message;
        $this->source = $source;
        $this->sendAt = $sendAt;
    }
}
