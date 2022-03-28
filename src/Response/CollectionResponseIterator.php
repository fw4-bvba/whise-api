<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Response;

class CollectionResponseIterator implements \Iterator
{
    /** @var CollectionResponse */
    protected $response;

    /** @var int */
    protected $position = 0;

    public function __construct(CollectionResponse $response)
    {
        $this->response = $response;
    }

    /* Iterator implementation */
    #[\ReturnTypeWillChange]
    public function current()
    {
        return $this->response->get($this->position);
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        $this->position++;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function valid(): bool
    {
        return $this->response->offsetExists($this->position);
    }
}
