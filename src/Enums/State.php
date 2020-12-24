<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Enums;

final class State extends Enum
{
    const New                  = 1;
    const VeryGood             = 2;
    const Refreshed            = 3;
    const Good                 = 4;
    const ToBeRefreshed        = 5;
    const ToBeRenovated        = 6;
    const ToBeRebuilt          = 7;
    const ToBeDemolished       = 8;
    const Unknown              = 9;
    const GreenEstate          = 10;
    const ToBeBuilt            = 11;
    const MainWork             = 12;
    const NewDevelopment       = 13;
    const MinorRenovation      = 14;
    const Renovated            = 15;
    const Concept              = 16;
    const Developed            = 17;
    const ReadyToStartBuilding = 18;
    const WallsClosed          = 19;
    const Constructed          = 20;
    const Delivered            = 21;
    const Plastered            = 22;
    const GroundToBePrepared   = 23;
    const GroundPrepared       = 24;
}
