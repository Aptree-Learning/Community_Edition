<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ContentLayout extends Enum
{
    const LeftImageRightText = 1;
    const LeftTextRightImage = 2;
    const TextOnly = 3;
    const ImageOnly = 4;
}
