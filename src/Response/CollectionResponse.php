<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Response;

use Whise\Api\Request\Request;
use Whise\Api\Request\CollectionRequest;

class CollectionResponse implements \Countable, \IteratorAggregate, \ArrayAccess, \JsonSerializable, CacheInterface
{
    use CacheTrait;

    /** @var array */
    protected $data;

    public function __construct(ResponseData $data)
    {
        $this->data = array_values($data->getData());
        $this->transferCacheAttributes($data);
    }

    /**
     * Get the item at a specific index.
     *
     * @return mixed
     */
    public function get(int $position)
    {
        return $this->data[$position];
    }

    /**
     * @codeCoverageIgnore
     */
    public function __debugInfo(): array
    {
        return $this->data;
    }

    /* Countable implementation */

    public function count(): int
    {
        return count($this->data);
    }

    /* IteratorAggregate implementation */

    public function getIterator(): CollectionResponseIterator
    {
        return new CollectionResponseIterator($this);
    }

    /* ArrayAccess implementation */

    public function offsetExists($offset): bool
    {
        if (!is_int($offset)) {
            return false;
        }
        return $offset >= 0 && $offset < $this->count();
    }

    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        if (!$this->offsetExists($offset)) {
            trigger_error('Undefined offset: ' . $offset);
        }
        return $this->get($offset);
    }

    /**
     * @codeCoverageIgnore
     */
    public function offsetSet($offset, $value): void
    {
        throw new \Exception('offsetSet not implemented on CollectionResponse');
    }

    /**
     * @codeCoverageIgnore
     */
    public function offsetUnset($offset): void
    {
        throw new \Exception('offsetUnset not implemented on CollectionResponse');
    }

    /* JsonSerializable implementation */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->data;
    }
}
