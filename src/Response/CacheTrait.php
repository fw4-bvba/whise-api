<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Response;

trait CacheTrait
{
    /** @var bool */
    protected $_cacheHit = false;

    /** @var string */
    protected $_cacheKey;

    public function setCacheHit(bool $cache_hit): void
    {
        $this->_cacheHit = $cache_hit;
    }

    public function isCacheHit(): bool
    {
        return $this->_cacheHit;
    }

    public function setCacheKey(?string $key): void
    {
        $this->_cacheKey = $key;
    }

    public function getCacheKey(): ?string
    {
        return $this->_cacheKey;
    }

    public function transferCacheAttributes(CacheInterface $other): void
    {
        $this->setCacheHit($other->isCacheHit());
        $this->setCacheKey($other->getCacheKey());
    }
}
