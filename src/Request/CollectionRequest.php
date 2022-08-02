<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Request;

use Whise\Api\WhiseApi;
use InvalidArgumentException;

class CollectionRequest extends Request
{
    /** @var int */
    protected $page;

    /** @var int */
    protected $pageSize;

    /**
     * {@inheritdoc}
     */
    public function getBody(): ?string
    {
        if (is_null($this->body)) {
            $this->body = [];
        }
        if (is_array($this->body)) {
            if (!isset($this->body['Page'])) {
                $this->body['Page'] = [];
            }
            $this->body['Page']['Limit'] = $this->getPageSize();
            $this->body['Page']['Offset'] = $this->getPageSize() * $this->getPage();
        }
        return parent::getBody();
    }

    /**
     * Set the page to be retrieved, starting at 0.
     *
     * @param int $page
     *
     * @return self
     */
    public function setPage(int $page): self
    {
        if ($page < 0) {
            throw new InvalidArgumentException('Page index must be 0 or greater');
        }
        $this->page = $page;
        return $this;
    }

    /**
     * Set the amount of items to be retrieved per page.
     *
     * @param int $page_size
     *
     * @return self
     */
    public function setPageSize(int $page_size): self
    {
        if ($page_size <= 0) {
            throw new InvalidArgumentException('Page size must greater than 0');
        }
        $this->pageSize = $page_size;
        return $this;
    }

    /**
     * Get the page to be retrieved, starting at 0.
     *
     * @return int
     */
    public function getPage(): int
    {
        return $this->page ?? 0;
    }

    /**
     * Get the amount of items to be retrieved per page.
     *
     * @return int
     */
    public function getPageSize(): int
    {
        return $this->pageSize ?? WhiseApi::getDefaultPageSize();
    }
}
