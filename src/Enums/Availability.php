<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Enums;

final class Availability extends Enum
{
    const AtContract     = 1;
    const TbdWithOwner   = 2;
    const TbdWithTenant  = 3;
    const Unavailable    = 4;
    const Immediately    = 5;
    const AtDelivery     = 6;
    const ToBeAgreedUpon = 7;
}
