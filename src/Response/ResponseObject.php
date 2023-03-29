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

class ResponseObject implements \JsonSerializable
{
    /** @var array */
    protected $_data = [];

    public function __construct($data)
    {
        if (!is_iterable($data) && !is_object($data)) {
            throw new InvalidDataException('ResponseObject does not accept data of type "' . gettype($data) . '"');
        }
        foreach ($data as $property => &$value) {
            if (is_array($data)) {
                $this->_data[] = $this->parseValue($value);
            } else {
                $this->_data[$property] = $this->parseValue($value, $property);
            }
        }
    }

    /**
     * Recursively parse Whise API data.
     *
     * @param mixed $value
     * @param string|null $property Name of the property to parse
     *
     * @return self
     */
    protected function parseValue($value, ?string $property = null)
    {
        if (is_object($value)) {
            return new self($value);
        } elseif (is_array($value)) {
            $result = [];
            foreach ($value as &$subvalue) {
                $result[] = $this->parseValue($subvalue, $property);
            }
            return $result;
        } elseif (preg_match('/^(?:[1-9]\d{3}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1\d|2[0-8])|(?:0[13-9]|1[0-2])-(?:29|30)|(?:0[13578]|1[02])-31)|(?:[1-9]\d(?:0[48]|[2468][048]|[13579][26])|(?:[2468][048]|[13579][26])00)-02-29)T(?:[01]\d|2[0-3]):[0-5]\d:[0-5]\d(?:\.\d{1,9})?(?:Z|[+-][01]\d:[0-5]\d)?$/', $value)) {
            return new \DateTime($value);
        } else {
            return $value;
        }
    }

    /**
     * Get all properties of this object.
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->_data;
    }

    public function __get(string $property)
    {
        $this->validatePropertyName($property);
        return $this->_data[$property] ?? null;
    }

    public function __set(string $property, $value)
    {
        $this->_data[$property] = $value;
    }

    public function __isset(string $property): bool
    {
        return isset($this->_data[$property]);
    }

    public function __unset(string $property)
    {
        $this->validatePropertyName($property);
        unset($this->_data[$property]);
    }

    /**
     * @codeCoverageIgnore
     */
    public function __debugInfo()
    {
        return $this->getData();
    }

    /**
     * Check if this object contains a specific property.
     *
     * @param string $property
     *
     * @throws InvalidPropertyException if the property does not exist
     *
     * @return string
     */
    protected function validatePropertyName(string $property): string
    {
        if (!array_key_exists($property, $this->_data)) {
            throw new InvalidPropertyException($property . ' is not a valid property of ' . static::class);
        }
        return $property;
    }

    /* JsonSerializable implementation */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->getData();
    }
}
