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
 * Interface NotificationEventInterface
 * @package App\Bundle\NotificationBundle\Event
 */
interface NotificationEventInterface
{
    /**
     * @return NotificationLevel
     */
    public function getLevel(): NotificationLevel;

    /**
     * @return string|null
     */
    public function getSource(): ?string;

    /**
     * @return string
     */
    public function getMessage(): string;

    /**
     * @return DateTimeInterface|null
     */
    public function getSendAt(): ?DateTimeInterface;
}
