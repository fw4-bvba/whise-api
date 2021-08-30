<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Enums;

final class ExportStatus extends Enum
{
    const ExportConfirmedByMedia        = 3;
    const ErrorDuringExport             = 4;
    const UpdateConfirmedByMedia        = 7;
    const ErrorDuringUpdate             = 8;
    const DeleteRequestConfirmedByMedia = 11;
    const ErrorDuringDelete             = 12;
}
