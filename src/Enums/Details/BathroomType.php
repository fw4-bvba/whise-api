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
 * Enum containing values for subdetails of type 1596, 1951, 1954 and 1957
 */
final class BathroomType extends Enum
{
    const NotFitted        = [690, 938, 947, 956];
    const Shower           = [691, 939, 948, 957];
    const Bath             = [692, 940, 949, 958];
    const HipBath          = [693, 941, 950, 959];
    const ShowerAndBath    = [694, 942, 951, 960];
    const ShowerAndHipBath = [695, 943, 952, 961];
    const ShowerInBath     = [696, 944, 953, 962];
    const AllComfort       = [697, 945, 954, 963];
    const Luxurious        = [698, 946, 955, 964];
}
