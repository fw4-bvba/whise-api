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
 * Enum containing values for subdetails of type 2222
 */
final class PossibleFloodType extends Enum
{
    const Effective  = 1229;
    const Potential  = 1230;
    const None       = 1233;
}
