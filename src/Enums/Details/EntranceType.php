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
 * Enum containing values for subdetails of type 905, 1512 and 1720
 */
final class EntranceType extends Enum
{
    const LargeDoor             = [123, 133, 138];
    const ManualSectionalDoor   = [124, 134, 139];
    const ElectricSectionalDoor = [125, 135, 140];
    const RollerBlind           = [126, 136, 141];
    const SlidingDoor           = [127, 137, 142];
}
