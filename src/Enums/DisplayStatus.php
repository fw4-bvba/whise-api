<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Enums;

final class DisplayStatus extends Enum
{
    const Offline           = 1;
    const Online            = 2;
    const EstateOfTheMonth  = 3;
    const Realisations      = 4;
    const OnlineWebsiteOnly = 5;
}
