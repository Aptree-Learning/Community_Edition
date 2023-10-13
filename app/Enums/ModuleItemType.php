<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ModuleItemType extends Enum
{
    const Content = 1;
    const Video = 2;
    const Document = 3;
    const Question = 4;
}
