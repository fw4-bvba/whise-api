<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Request\Exports;

use Whise\Api\Request\CollectionRequest as BaseCollectionRequest;

class CollectionRequest extends BaseCollectionRequest
{
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
            $this->body['Page']['Offset'] = $this->getPage();
        }

        if (is_null($this->body) || is_string($this->body)) {
            return $this->body;
        } else {
            return json_encode($this->encode($this->body));
        }
    }
}
