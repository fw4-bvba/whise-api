<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Enums;

final class PurposeStatus extends Enum
{
    const ForSale = 1;
    const ForRent = 2;
    const Sold = 3;
    const Rented = 4;
    const ForSaleOption = 5;
    const ForRentOption = 6;
    const ForSaleCancelled = 8;
    const ForRentCancelled = 9;
    const ForSaleSuspended = 10;
    const ForRentSuspended = 11;
    const ForSaleOptionByOwner = 12;
    const ForRentOptionByOwner = 13;
    const SoldConditionally = 14;
    const LifeAnnuityForSale = 15;
    const LifeAnnuityForSaleOption = 16;
    const LifeAnnuitySold = 17;
    const ProspectionSale = 19;
    const Preparation = 20;
    const Reserved = 21;
    const Compromise = 22;
    const ProspectionRent = 23;
    const EstimateForSale = 24;
    const EstimateForRent = 25;
    const EstimateLifeAnnuity = 26;
}
