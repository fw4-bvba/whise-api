<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Response;

class CollectionResponseCountless extends CollectionResponsePaginated
{
    /** @var int */
    protected $totalCountUpperBound;

    /** @var int */
    protected $totalCountLowerBound = 0;

    /**
     * {@inheritdoc}
     */
    protected function bufferPage(int $page): void
    {
        parent::bufferPage($page);

        // Update total count bounds
        if ($this->pageBuffer->count() > 0) {
            $this->totalCountLowerBound = max($this->totalCountLowerBound ?? 0, $page * $this->pageBuffer->getPageSize() + $this->pageBuffer->count());
            if ($this->pageBuffer->count() < $this->pageBuffer->getPageSize()) {
                $this->totalCountUpperBound = $this->totalCountLowerBound;
            }
        } elseif (isset($this->totalCountUpperBound)) {
            $this->totalCountUpperBound = min($this->totalCountUpperBound, $page * $this->pageBuffer->getPageSize());
        } else {
            $this->totalCountUpperBound = $page * $this->pageBuffer->getPageSize();
        }
    }

    /**
     * Check whether or not we've been able to determine the total row count.
     *
     * @return bool
     */
    protected function hasReachedEnd(): bool
    {
        return !is_null($this->totalCountUpperBound) && $this->totalCountUpperBound === $this->totalCountLowerBound;
    }

    /* ArrayAccess implementation */

    public function offsetExists($offset): bool
    {
        if (!is_int($offset)) {
            return false;
        }
        if (!$this->hasReachedEnd()) {
            $this->bufferPosition($offset);
        }
        return $offset >= 0 && $offset < $this->totalCountLowerBound;
    }

    /* Countable implementation */

    public function count(): int
    {
        if (is_null($this->pageBuffer)) {
            $this->bufferPage(0);
        }
        return $this->totalCountLowerBound;
    }
}
