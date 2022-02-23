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
 * Enum containing values for subdetails of type 990, 1590 and 1732
 */
final class DockType extends Enum
{
    const Dock       = [772, 775, 778];
    const Adjustable = [773, 776, 779];
    const Covered    = [774, 777, 780];
}
