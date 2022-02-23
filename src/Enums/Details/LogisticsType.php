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
 * Enum containing values for subdetails of type 989, 1589 and 1731
 */
final class LogisticsType extends Enum
{
    const Waterway = [111, 114, 117];
    const Railroad = [112, 115, 118];
    const Highway  = [113, 116, 119];
}
