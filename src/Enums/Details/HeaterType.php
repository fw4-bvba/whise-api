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
 * Enum containing values for subdetails of type 1020, 2114 and 2115
 */
final class HeaterType extends Enum
{
    const None                 = [658, 1013, 1035];
    const GasBurner            = [659, 1014, 1036];
    const Gas                  = [660, 1015, 1037];
    const FuelBurner           = [661, 1016, 1038];
    const Electrical           = [662, 1017, 1039];
    const Coal                 = [663, 1018, 1040];
    const Wood                 = [664, 1019, 1041];
    const Solar                = [665, 1020, 1042];
    const HotAir               = [666, 1021, 1043];
    const HeatPump             = [667, 1022, 1044];
    const HotAirBlowerGas      = [668, 1023, 1045];
    const HotAirBlowerFuel     = [669, 1024, 1046];
    const GasStove             = [670, 1025, 1047];
    const OilStove             = [671, 1026, 1048];
    const FloorHeating         = [672, 1027, 1049];
    const GasPipesInstalled    = [673, 1028, 1050];
    const CityHeating          = [674, 1029, 1051];
    const ElectricAccumulators = [675, 1030, 1052];
    const CeilingHeating       = [676, 1031, 1053];
    const Pellets              = [1000, 1032, 1054];
    const WoodStove            = [1001, 1033, 1055];
    const Cassette             = [1002, 1034, 1056];
    const FuelStove            = [1168, 1169, 1170];
    const Aerothermal          = [1490, 1492, 1494];
    const Boiler               = [1491, 1493, 1495];
    const Condensation         = [1547];
}
