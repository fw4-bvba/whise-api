<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Enums;

final class Status extends Enum
{
    const Active   = 1;
    const Archived = 5;
    const Deleted  = 6;
}
