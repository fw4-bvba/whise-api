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
 * Enum containing values for subdetails of type 1592
 */
final class CompressedAirType extends Enum
{
    const Type220V    = [743];
    const Type315V    = [744];
    const Type380V    = [745];
    const HighVoltage = [746];
}
