<?php

namespace FeedReader\Infrastructure\Persistence\Doctrine\CustomType;

use Doctrine\DBAL\Platforms\AbstractPlatform
    , Doctrine\DBAL\Types\GuidType;

/**
 * Class DoctrineEntityId
 * @package FeedReader\Infrastructure\Persistence\Doctrine\CustomType
 */
class DoctrineEntityId extends GuidType
{
    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->id();
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return mixed
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $className = $this->getNamespace() . '\\' . $this->getName();

        return new $className($value);
    }
}