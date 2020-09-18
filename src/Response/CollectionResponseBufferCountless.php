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

class CollectionResponseBufferCountless extends CollectionResponseBuffer
{
    /** @var int */
    protected $rowCountUpperBound;

    /**
     * {@inheritdoc}
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
        
        foreach ($response->getData() as $row) {
            $this->buffer[] = $row;
        }
        
        if (count($this->buffer)) {
            $this->rowCount = max($this->rowCount, $page * $this->pageSize + count($this->buffer));
            if (count($this->buffer) < $this->pageSize) {
                $this->rowCountUpperBound = $this->rowCount;
            }
        } elseif (isset($this->rowCountUpperBound)) {
            $this->rowCountUpperBound = min($this->rowCountUpperBound, $page * $this->pageSize);
        } else {
            $this->rowCountUpperBound = $page * $this->pageSize;
        }
    }
    
    /**
     * Check whether or not we've been able to determine the total row count.
     *
     * @return bool
     */
    public function hasReachedEnd(): bool
    {
        return $this->rowCountUpperBound === $this->rowCount;
    }
    
    /**
     * {@inheritdoc}
     */
    public function offsetExists(int $position): bool
    {
        if (!$this->hasReachedEnd()) {
            $this->bufferPosition($position);
        }
        return parent::offsetExists($position);
    }
}
