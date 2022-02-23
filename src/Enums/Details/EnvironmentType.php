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
 * Enum containing values for subdetails of type 795, 1447 and 1700
 */
final class EnvironmentType extends Enum
{
    const Countryside          = [51, 71, 91];
    const Quiet                = [52, 72, 92];
    const Woods                = [53, 73, 93];
    const City                 = [54, 74, 94];
    const CityCenter           = [55, 75, 95];
    const Suburb               = [56, 76, 96];
    const Residential          = [57, 77, 97];
    const Villa                = [58, 78, 98];
    const Commercial           = [59, 79, 99];
    const NearRailwayStation   = [60, 80, 100];
    const Industrial           = [61, 81, 101];
    const IndustrialEstate     = [62, 82, 102];
    const SME                  = [63, 83, 103];
    const AdministrationCenter = [64, 84, 104];
    const Downtown             = [65, 85, 105];
    const HolidayResort        = [66, 86, 106];
    const SeaFront             = [67, 87, 107];
    const SeaView              = [68, 88, 108];
    const SunnySide            = [69, 89, 109];
    const Central              = [70, 90, 110];
    const Golf                 = [1482, 1484, 1486];
    const NearBeach            = [1483, 1485, 1487];
}
