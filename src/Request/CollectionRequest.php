<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Request;

class CollectionRequest extends Request
{
    protected const LIMIT = 50;
    
    /**
     * {@inheritdoc}
     */
    public function setBody($body): Request
    {
        if (is_array($body)) {
            $body['Limit'] = self::LIMIT;
            if (!isset($body['Offset'])) {
                $body['Offset'] = 0;
            }
        }
        return parent::setBody($body);
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
        if (is_array($this->body)) {
            $this->body['Offset'] = $page * self::LIMIT;
        }
        return $this;
    }
    
    /**
     * Get the amount of items to be retrieved per page.
     *
     * @return int
     */
    public function getPageSize(): int
    {
        return self::LIMIT;
    }
}
