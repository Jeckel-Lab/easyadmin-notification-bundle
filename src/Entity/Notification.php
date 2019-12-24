<?php

namespace JeckelLab\NotificationBundle\Entity;

use JeckelLab\NotificationBundle\ValueObject\NotificationLevel;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="JeckelLab\NotificationBundle\Repository\NotificationRepository")
 */
class Notification
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="string", length=36, name="notification_id")
     * @var string|null
     */
    private $notificationId;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTimeInterface|null
     */
    private $send_at;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string|null
     */
    private $source;

    /**
     * @ORM\Column(type="notification_level")
     * @var NotificationLevel
     */
    private $level;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    private $message = '';

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var DateTimeInterface|null
     */
    private $read_at;

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->notificationId;
    }

    /**
     * @return string|null
     */
    public function getNotificationId(): ?string
    {
        return $this->getId();
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getSendAt(): ?DateTimeInterface
    {
        return $this->send_at;
    }

    /**
     * @param DateTimeInterface $date
     * @return $this
     */
    public function setSendAt(DateTimeInterface $date): self
    {
        $this->send_at = $date;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSource(): ?string
    {
        return $this->source;
    }

    /**
     * @param string|null $source
     * @return $this
     */
    public function setSource(?string $source): self
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @return NotificationLevel|null
     */
    public function getLevel(): ?NotificationLevel
    {
        return $this->level;
    }

    /**
     * @param NotificationLevel $level
     * @return $this
     */
    public function setLevel(NotificationLevel $level): self
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getReadAt(): ?DateTimeInterface
    {
        return $this->read_at;
    }

    /**
     * @param DateTimeInterface|null $read_at
     * @return $this
     */
    public function setReadAt(?DateTimeInterface $read_at): self
    {
        $this->read_at = $read_at;

        return $this;
    }

    /**
     * @param DateTimeInterface $readAt
     * @return $this
     */
    public function markRead(DateTimeInterface $readAt): self
    {
        if (null === $this->read_at) {
            $this->read_at = $readAt;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (empty($this->source)) {
            return $this->message;
        }
        return sprintf('%s: %s', $this->source, $this->message);
    }
}
