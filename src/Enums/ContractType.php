<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Enums;

final class ContractType extends Enum
{
    const Exclusive           = 1;
    const Cooperation         = 2;
    const NonExclusive        = 3;
    const CoExclusive         = 4;
    const ExclusiveAndByOwner = 5;
    const ThroughOtherAgent   = 6;
    const RelationVerbal      = 7;
    const NonExclusiveVerbal  = 8;
    const NoMandate           = 9;
    const Pending             = 10;
    const Seizure             = 11;
}
