<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Response;

use Whise\Api\Exception\ApiException;
use Whise\Api\Request\CollectionRequest;
use Whise\Api\ApiAdapter\ApiAdapterInterface;

class CollectionResponseBuffer
{
    /** @var CollectionRequest */
    protected $request;
    
    /** @var ApiAdapterInterface */
    protected $apiAdapter;
    
    /** @var array */
    protected $buffer;
    
    /** @var int */
    protected $rowCount = 0;
    
    /** @var int */
    protected $pageSize;
    
    /** @var int */
    protected $page;

    public function __construct(CollectionRequest $request, ApiAdapterInterface $api_adapter)
    {
        $this->request = $request;
        $this->apiAdapter = $api_adapter;
        $this->pageSize = $request->getPageSize();

        $this->bufferPage(0);
    }

    /**
     * Get the total amount of items available.
     *
     * @return int
     */
    public function getRowCount(): int
    {
        return $this->rowCount;
    }

    /**
     * Get the amount of items contained per page.
     *
     * @return int
     */
    public function getPageSize(): int
    {
        return $this->pageSize;
    }
    
    /**
     * Get the currently buffered data.
     *
     * @return array
     */
    public function getBuffer(): array
    {
        return $this->buffer;
    }
    
    /**
     * Get the currently buffered page number.
     *
     * @return int
     */
    public function getBufferedPage(): int
    {
        return $this->page;
    }

    /**
     * Get the item at a specific index.
     *
     * @return mixed
     */
    public function get(int $position)
    {
        if (!$this->isBuffered($position)) {
            $this->bufferPosition($position);
        }
        return $this->buffer[$position % $this->pageSize];
    }
    
    /**
     * Check if an item is available at a specific index.
     *
     * @return bool
     */
    public function offsetExists(int $position): bool
    {
        return $position >= 0 && $position < $this->rowCount;
    }
    
    /**
     * Make sure the item at a specific index is loaded into the buffer.
     *
     * @param int $position
     */
    public function bufferPosition(int $position): void
    {
        $this->bufferPage(floor($position / $this->pageSize));
    }
    
    /**
     * Load a specific page into the buffer.
     *
     * @param int $page
     */
    public function bufferPage(int $page): void
    {
        if ($this->page === $page) {
            return;
        }
        $this->page = $page;

        $this->request->setPage($page);
        $response = $this->apiAdapter->request($this->request);

        $this->buffer = [];
        $this->current = 0;
        $this->rowCount = $response->metadata('totalCount');
        
        foreach ($response->getData() as $row) {
            $this->buffer[] = $row;
        }
    }

    /**
     * Check whether the item at a specific position is contained within the
     * current buffer.
     *
     * @return bool
     */
    public function isBuffered(int $position): bool
    {
        $first_position = $this->pageSize * $this->page;
        return ($position >= $first_position && $position < $first_position + count($this->buffer));
    }
}
