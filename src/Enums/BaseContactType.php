<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Enums;

final class BaseContactType extends Enum
{
    const Media           = 1;
    const Owner           = 3;
    const PotentialBuyer  = 4;
    const PotentialTenant = 5;
    const Tenant          = 6;
    const DefaultView     = 11;
    const Buyer           = 12;
    const NotarySeller    = 13;
    const Promotor        = 14;
    const Syndic          = 15;
    const Janitor         = 16;
    const Architect       = 17;
    const CoAgent         = 18;
    const SubAgent        = 19;
    const MasterAgent     = 20;
    const OtherAgent      = 21;
    const Blacklisted     = 22;
    const NotaryBuyer     = 23;
}
