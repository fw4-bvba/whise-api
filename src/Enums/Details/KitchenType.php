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
 * Enum containing values for subdetails of type 1595
 */
final class KitchenType extends Enum
{
    const NotFitted           = [683];
    const SemiFitted          = [684];
    const Fitted              = [685];
    const FullyFitted         = [686];
    const SemiFittedAmerican  = [687];
    const FittedAmerican      = [688];
    const FullyFittedAmerican = [689];
}
