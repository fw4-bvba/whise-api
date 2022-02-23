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
 * Enum containing values for subdetails of type 1001
 */
final class RoofType extends Enum
{
    const Gambrel   = [797];
    const Dome      = [799];
    const Shed      = [799];
    const Mansard   = [800];
    const Hip       = [801];
    const Flat      = [802];
    const Sloped    = [803];
    const Pyramid   = [804];
    const Thatched  = [805];
    const Tented    = [806];
    const Butterfly = [807];
    const HalfHip   = [808];
    const Gable     = [809];
}
