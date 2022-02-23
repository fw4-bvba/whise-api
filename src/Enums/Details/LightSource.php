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
 * Enum containing values for subdetails of type 1632
 */
final class LightSource extends Enum
{
    const Daylight   = [752];
    const Artificial = [753];
    const Spots      = [754];
    const Freon      = [755];
    const Skylight   = [756];
    const TubeLight  = [757];
    const LightDome  = [758];
    const LED        = [1256];
    const GasLamp    = [1257];
}
