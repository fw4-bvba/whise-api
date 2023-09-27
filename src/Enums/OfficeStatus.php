<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Enums;

final class OfficeStatus extends Enum
{
    const Archived = 0;
    const Normal   = 1;
    const Pending  = 2;
    const Deleted  = 3;
}
