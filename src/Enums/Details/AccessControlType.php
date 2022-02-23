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
 * Enum containing values for subdetails of type 1353 and 1663
 */
final class AccessControlType extends Enum
{
    const Barrier   = [810, 815];
    const Badge     = [811, 816];
    const Fence     = [812, 817];
    const Security  = [813, 818];
    const Concierge = [814, 819];
}
