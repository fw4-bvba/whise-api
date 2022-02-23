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
 * Enum containing values for subdetails of type 1432
 */
final class ElectricityType extends Enum
{
    const Type220V    = [739];
    const Type315V    = [740];
    const Type380V    = [741];
    const HighVoltage = [742];
}
