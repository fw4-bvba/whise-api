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
use Whise\Api\ApiAdapter\ApiAdapterInterface;

class CollectionResponsePaginated extends CollectionResponse
{
    /** @var CollectionResponseBuffer */
    protected $buffer;

    public function __construct(CollectionRequest $request, ApiAdapterInterface $api_adapter)
    {
        $this->buffer = new CollectionResponseBuffer($request, $api_adapter);
    }

    /**
     * {@inheritdoc}
     */
    public function get(int $position)
    {
        return $this->buffer->get($position);
    }
    
    /**
     * Get the amount of items contained per page.
     *
     * @return int
     */
    public function getPageSize(): int
    {
        return $this->buffer->getPageSize();
    }
    
    /**
     * Get the amount of pages available.
     *
     * @return int
     */
    public function getPageCount(): int
    {
        return intval(ceil($this->count() / $this->getPageSize()));
    }
    
    /**
     * @codeCoverageIgnore
     */
    public function __debugInfo(): array
    {
        return [
            'count' => $this->count(),
            'pageData' => $this->buffer->getBuffer(),
            'pageSize' => $this->getPageSize(),
            'pageCount' => $this->getPageCount(),
        ];
    }

    /* Countable implementation */

    public function count(): int
    {
        return $this->buffer->getRowCount();
    }
}
