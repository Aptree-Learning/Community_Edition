<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ActionType extends Enum
{
    const Create = 1;
    const Update = 2;
    const Delete = 3;
}
