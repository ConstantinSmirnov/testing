<?php

namespace App\Testing\Domain\Enum;

enum QuestionTypeEnum: string
{
    case FUZZY_LOGIC = 'FUZZY_LOGIC';
    case IS_NOT_FUZZY_LOGIC = 'IS_NOT_FUZZY_LOGIC';
}