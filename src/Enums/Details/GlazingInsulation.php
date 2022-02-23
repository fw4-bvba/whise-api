<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Enums\Details;

use Whise\Api\Enums\Enum;

/**
 * Enum containing values for subdetails of type 1634
 */
final class GlazingInsulation extends Enum
{
    const Thermic            = [769];
    const Acoustic           = [770];
    const ThermicAndAcoustic = [771];
}
