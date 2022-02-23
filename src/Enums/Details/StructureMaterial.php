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
 * Enum containing values for subdetails of type 906
 */
final class StructureMaterial extends Enum
{
    const Concrete = 652;
    const Steel    = 653;
    const Wood     = 654;
    const Bricks   = 1224;
    const BCA      = 1225;
    const Prefab   = 1800;
    const Clay     = 1801;
    const Other    = 1802;
}
