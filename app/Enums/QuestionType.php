<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class QuestionType extends Enum
{
    const MultipleChoice = 1;
    const Ai = 2;
    const TrueFalse = 3;
    const FillBlanks = 4;
    const LikertScale = 5;
}