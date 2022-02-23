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
 * Enum containing values for subdetails of type 890, 2231, 2308, 2309 and 1827
 */
final class FrontageType extends Enum
{
    const Brick               = [23, 1264, 1380, 1391, 833];
    const Glass               = [24, 1265, 1381, 1392, 834];
    const Stone               = [25, 1266, 1382, 1393, 835];
    const Aluminium           = [26, 1267, 1383, 1394, 836];
    const Concrete            = [1258, 1268, 1384, 1395];
    const Silex               = [1259, 1269, 1385, 1396];
    const Panels              = [1260, 1270, 1386, 1397];
    const Metal               = [1261, 1271, 1387, 1398];
    const Masonry             = [1262, 1272, 1388, 1399];
    const Other               = [1263, 1273, 1390, 1401];
    const StructuralLinerTray = [1371, 1372, 1389, 1400];
    const Plastered           = [1403, 1402, 1404, 1405];
    const Wood                = [1719, 1720];
}
