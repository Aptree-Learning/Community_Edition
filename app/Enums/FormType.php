<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class FormType extends Enum
{
    const Textbox = 0;
    const Textarea = 1;
    const Colorpicker = 2;
    const Fileupload = 3;
    const Checkbox = 4;
}
