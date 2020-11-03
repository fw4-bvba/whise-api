<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Response;

use Whise\Api\Exception\InvalidPropertyException;
use Whise\Api\Exception\InvalidDataException;
use Whise\Api\ApiAdapter\ApiAdapter;

class ResponseData extends ResponseObject
{
    /** @var array */
    protected $_metadata = [];

    public function __construct($data, $metadata = null)
    {
        parent::__construct($data);

        if (isset($metadata)) {
            if (!is_iterable($metadata) && !is_object($metadata)) {
                throw new InvalidDataException('ResponseData does not accept metadata of type "' . gettype($data) . '"');
            }
            foreach ($metadata as $property => &$value) {
                $this->_metadata[$property] = $this->parseValue($value, $property);
            }
        }
    }

    /**
     * Get all metadata from this response.
     *
     * @return array
     */
    public function getMetadata(): array
    {
        return $this->_metadata;
    }

    /**
     * Get specific metadata from this response.
     *
     * @param string $property
     *
     * @throws InvalidPropertyException if the metadata does not exist
     *
     * @return string
     */
    public function metadata(string $property)
    {
        if (!$this->hasMetadata($property)) {
            throw new InvalidPropertyException($property . ' is not valid metadata of ' . static::class);
        }
        return $this->_metadata[$property];
    }

    /**
     * Checks if this response has specific metadata.
     *
     * @param string $property
     *
     * @return bool True if metadata exists
     */
    public function hasMetadata(string $property): bool
    {
        return array_key_exists($property, $this->_metadata);
    }
}
