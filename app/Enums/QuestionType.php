<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class QuestionType extends Enum
{
    const Classic =   0;
    const Audio =   1;
    const Picture = 2;
    const FillTheBlank = 3;
}
