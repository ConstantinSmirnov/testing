<?php

namespace App\Testing\Domain\Converter;

use App\Testing\Domain\Enum\QuestionTypeEnum;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class QuestionTypeEnumConverter extends StringType
{
    const QUESTION_TYPE = 'question_type';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return "VARCHAR(255)";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?QuestionTypeEnum
    {
        return $value !== null ? QuestionTypeEnum::from($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value?->value;
    }

    public function getName(): string
    {
        return self::QUESTION_TYPE;
    }
}