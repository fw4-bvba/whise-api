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
 * Enum containing values for subdetails of type 1637
 */
final class FirePreventionType extends Enum
{
    const Extinguishers  = [759];
    const FireReels      = [760];
    const Sprinklers     = [761];
    const SmokeDetectors = [762];
}
