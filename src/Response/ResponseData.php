<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Response;

use Whise\Api\Exception\InvalidDataException;

class ResponseData extends ResponseObject implements CacheInterface
{
    use CacheTrait;
    use MetadataTrait;

    public function __construct($data, $metadata = null)
    {
        parent::__construct($data);

        if (isset($metadata)) {
            if (!is_iterable($metadata) && !is_object($metadata)) {
                throw new InvalidDataException('ResponseData does not accept metadata of type "' . gettype($data) . '"');
            }
            foreach ($metadata as $property => &$value) {
                $this->addMetadata($property, $this->parseValue($value, $property));
            }
        }
    }
}
