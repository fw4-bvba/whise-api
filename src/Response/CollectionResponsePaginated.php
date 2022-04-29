<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Response;

use Whise\Api\Request\CollectionRequest;
use Whise\Api\ApiAdapter\ApiAdapter;
use Whise\Api\WhiseApi;

class CollectionResponsePaginated extends CollectionResponse
{
    /** @var CollectionRequest */
    protected $request;

    /** @var ApiAdapter */
    protected $apiAdapter;

    /** @var CollectionResponsePage */
    protected $pageBuffer;

    public function __construct(CollectionRequest $request, ApiAdapter $api_adapter)
    {
        $this->request = $request;
        $this->apiAdapter = $api_adapter;
    }

    /**
     * Get the items from a single page.
     *
     * @param int $page Index of the page to fetch, starting at 0
     * @param int $page_size Amount of items to retrieve per page
     *
     * @return CollectionResponsePage
     */
    public function page(int $page, int $page_size): CollectionResponsePage
    {
        return new CollectionResponsePage($this->apiAdapter->request(
            $this->request->setPage($page)->setPageSize($page_size)
        ), $page, $page_size);
    }

    /**
     * Get the item at a specific index.
     *
     * @param int $position
     *
     * @return mixed
     */
    public function get(int $position)
    {
        if (!$this->isBuffered($position)) {
            $this->bufferPosition($position);
        }
        return $this->pageBuffer->get($position % WhiseApi::getDefaultPageSize());
    }

    /**
     * Check whether the item at a specific position is contained within the
     * current buffer.
     *
     * @param int $position
     *
     * @return bool
     */
    protected function isBuffered(int $position): bool
    {
        if (is_null($this->pageBuffer)) {
            return false;
        }
        $first_position = WhiseApi::getDefaultPageSize() * $this->pageBuffer->getPage();
        return ($position >= $first_position && $position < $first_position + $this->pageBuffer->count());
    }

    /**
     * Load the item at a specific index into the buffer.
     *
     * @param int $position
     */
    protected function bufferPosition(int $position): void
    {
        $this->bufferPage(floor($position / WhiseApi::getDefaultPageSize()));
    }

    /**
     * Load a specific page into the buffer.
     *
     * @param int $page
     */
    protected function bufferPage(int $page): void
    {
        if (is_null($this->pageBuffer) || $this->pageBuffer->getPage() !== $page) {
            $this->pageBuffer = $this->page($page, WhiseApi::getDefaultPageSize());
        }
    }

    /**
     * Get the current page buffer, or fetch the initial one
     *
     * @return CollectionResponsePage
     */
    protected function getCurrentPageBuffer(): CollectionResponsePage
    {
        if (is_null($this->pageBuffer)) {
            $this->bufferPage(0);
        }
        return $this->pageBuffer;
    }

    /**
     * @codeCoverageIgnore
     */
    public function __debugInfo(): array
    {
        return $this->getCurrentPageBuffer()->__debugInfo();
    }

    /* Countable implementation */

    public function count(): int
    {
        return $this->getCurrentPageBuffer()->getTotalCount() ?? 0;
    }

    /* Metadata */

    /**
     * {@inheritdoc}
     */
    public function getMetadata(): array
    {
        return $this->getCurrentPageBuffer()->getMetadata();
    }

    /**
     * {@inheritdoc}
     */
    public function metadata(string $property)
    {
        return $this->getCurrentPageBuffer()->metadata($property);
    }

    /**
     * {@inheritdoc}
     */
    public function hasMetadata(string $property): bool
    {
        return $this->getCurrentPageBuffer()->hasMetadata($property);
    }
}
