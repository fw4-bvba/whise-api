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
 * Enum containing values for subdetails of type 23, 1000, 1737, 2098 and 2099
 */
final class Orientation extends Enum
{
    const North     = [27, 35, 43, 978, 987];
    const NorthEast = [28, 36, 44, 979, 988];
    const East      = [29, 37, 45, 980, 989];
    const SouthEast = [30, 38, 46, 981, 990];
    const South     = [31, 39, 47, 982, 991];
    const SouthWest = [32, 40, 48, 983, 992];
    const West      = [33, 41, 49, 984, 993];
    const NorthWest = [34, 42, 50, 985, 994];
}
