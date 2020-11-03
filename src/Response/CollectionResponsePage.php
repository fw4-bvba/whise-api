<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Response;

use Whise\Api\Exception\PaginationException;

class CollectionResponsePage extends CollectionResponse
{
    /** @var int */
    protected $page;

    /** @var int */
    protected $pageSize;

    /** @var int */
    protected $totalCount;

    public function __construct(ResponseData $data, int $page, int $page_size)
    {
        parent::__construct($data);

        $this->page = $page;
        $this->pageSize = $page_size;

        if ($data->hasMetadata('totalCount')) {
            $this->totalCount = $data->metadata('totalCount');
        }
    }

    /**
     * Get the index of this page.
     *
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * Get the maximum amount of items requested for this page.
     *
     * @return int
     */
    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    /**
     * Check whether a complete item count was returned by the API.
     *
     * @return bool
     */
    public function hasTotalCount(): bool
    {
        return !is_null($this->totalCount);
    }

    /**
     * Get the total amount of items across all pages.
     *
     * @throws PaginationException if the endpoint does not support this functionality
     *
     * @return int
     */
    public function getTotalCount(): int
    {
        if (!$this->hasTotalCount()) {
            throw new PaginationException('Unable to retrieve total item count of endpoint that does not return totalCount');
        }
        return $this->totalCount;
    }

    /**
     * Get the total amount of pages.
     *
     * @throws PaginationException if the endpoint does not support this functionality
     *
     * @return int
     */
    public function getPageCount(): int
    {
        return ceil($this->getTotalCount() / $this->getPageSize());
    }
}
