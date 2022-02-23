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
 * Enum containing values for subdetails of type 1736
 */
final class GroundDestination extends Enum
{
    const Agricultural         = 1;
    const EconomicActivity     = 2;
    const Extraction           = 3;
    const Reserve              = 4;
    const Forest               = 5;
    const Industrial           = 6;
    const DayLeisure           = 7;
    const StayingLeisure       = 8;
    const MixedResidential     = 9;
    const Nature               = 10;
    const Park                 = 11;
    const Residential          = 12;
    const ResidentialValuable  = 13;
    const ResidentialPark      = 14;
    const ResidentialExtension = 15;
    const GreenBelt            = 16;
    const NatureReserve        = 17;
    const AgriculturalValuable = 18;
    const IndustrialSME        = 19;
    const ResidentialRural     = 999;
    const Other                = 1839;
    const UrbanDevelopment     = 1871;
}
