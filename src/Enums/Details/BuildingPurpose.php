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
 * Enum containing values for subdetails of type 904 and 1511
 */
final class BuildingPurpose extends Enum
{
    const SingleFamily           = [882, 898];
    const SingleFamilyWithOffice = [883, 899];
    const MultipleFamilies       = [884, 900];
    const Independent            = [885, 901];
    const IndependentWithHousing = [886, 902];
    const Office                 = [887, 903];
    const Commerce               = [888, 904];
    const Catering               = [889, 905];
    const CommerceWithHousing    = [890, 906];
    const InvestmentEstate       = [891, 907];
    const InvestmentHouse        = [892, 908];
    const InvestmentApartment    = [893, 909];
    const InvestmentCommerce     = [894, 910];
    const InvestmentOffice       = [895, 911];
    const InvestmentMixed        = [896, 912];
    const SecondHouse            = [897, 913];
    const TwoFamilies            = [914, 915];
    const Housing                = [916, 922];
    const EmbassyChancellery     = [917, 923];
    const EmbassyResidence       = [918, 924];
    const Warehouse              = [919, 925];
    const Workshop               = [920, 926];
    const Multifunctional        = [921, 927];
    const OfficePrestigious      = [928, 929];
    const Agricultural           = [995, 996];
    const NoDomiciliation        = [997, 998];
    const Gite                   = [1164, 1166];
    const Wellness               = [1165, 1167];
    const SME                    = [1369, 1370];
    const Production             = [640, 646];
    const Storage                = [641, 647];
    const Studio                 = [642, 648];
    const Factory                = [643, 649];
    const Polyvalent             = [644, 650];
    const Showroom               = [645, 951];
}
