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
 * Enum containing values for subdetails of type 2157 and 2158
 */
final class Glazing extends Enum
{
    const Single        = [1003, 1007];
    const Double        = [1004, 1008];
    const Triple        = [1005, 1009];
    const Mixed         = [1006, 1010];
    const SunProtection = [1297, 1299];
    const Other         = [1298, 1300];
}
