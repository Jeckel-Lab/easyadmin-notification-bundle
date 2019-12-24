<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 25/11/2019
 */

namespace JeckelLab\NotificationBundle\DBAL\Types;

use JeckelLab\NotificationBundle\ValueObject\NotificationLevel;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * Class NotificationLevelType
 * @package App\Doctrine\Type
 */
class NotificationLevelType extends Type
{
    protected const TYPE_NAME = 'notification_level';

    /**
     * @param array            $fieldDeclaration
     * @param AbstractPlatform $platform
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::TYPE_NAME;
    }

    /**
     * @param mixed            $value
     * @param AbstractPlatform $platform
     * @return NotificationLevel
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): NotificationLevel
    {
        return NotificationLevel::byValue($value);
    }

    /**
     * @param mixed            $value
     * @param AbstractPlatform $platform
     * @return string
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        if ($value instanceof NotificationLevel) {
            $value = $value->getValue();
        }
        return $value;
    }
}
