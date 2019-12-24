<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 25/11/2019
 */

namespace JeckelLab\NotificationBundle\Event;

use JeckelLab\NotificationBundle\ValueObject\NotificationLevel;
use DateTimeInterface;

/**
 * Trait NotificationEventTrait
 * @package App\Bundle\NotificationBundle\Event
 */
trait NotificationEventTrait
{
    /** @var NotificationLevel */
    protected $level;

    /** @var string|null */
    protected $source;

    /** @var string */
    protected $message = '';

    /** @var DateTimeInterface|null */
    protected $sendAt;

    /**
     * @return NotificationLevel
     */
    public function getLevel(): NotificationLevel
    {
        return $this->level;
    }

    /**
     * @return string|null
     */
    public function getSource(): ?string
    {
        return $this->source;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getSendAt(): ?DateTimeInterface
    {
        return $this->sendAt;
    }
}
