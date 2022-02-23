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
 * Enum containing values for subdetails of type 2712
 */
final class SummonsType extends Enum
{
    const Summon                = 1832;
    const LegalCorrection       = 1833;
    const AdministrativeMeasure = 1834;
    const CeaseAndDesist        = 1835;
    const Settlement            = 1836;
    const None                  = 1837;
}
