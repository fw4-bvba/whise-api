<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Response;

use Whise\Api\Exception\InvalidPropertyException;

trait MetadataTrait
{
    /** @var array */
    protected $_metadata = [];

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
     * Set/replace metadata from this response.
     */
    public function setMetadata(array $metadata): void
    {
        $this->_metadata = $metadata;
    }

    /**
     * Set/replace specific metadata values
     */
    public function addMetadata(string $property, $value): void
    {
        $this->_metadata[$property] = $value;
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
