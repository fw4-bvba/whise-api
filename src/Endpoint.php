<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api;

use Whise\Api\ApiAdapter\ApiAdapter;

abstract class Endpoint
{
    /** @var WhiseAPI */
    protected $api;
    
    public function __construct(WhiseAPI $api)
    {
        $this->api = $api;
    }
    
    public function getApiAdapter(): ApiAdapter
    {
        return $this->api->getApiAdapter();
    }
    
    /**
     * Check if an array is associative or sequential
     *
     * @param array
     *
     * @return bool True if associative, false if sequential
     */
    protected function arrayIsAssociative(array &$array): bool
    {
        return (array_values($array) !== $array);
    }
    
    /**
     * Normalize input parameters for endpoints that accept specific parameters.
     *
     * @param array $input
     *
     * @return array
     */
    protected function getFilterParameters(array $input): array
    {
        $fields = array_map('strtolower', array_keys($input));
        
        $parameters = [];
        foreach ($input as $field => $values) {
            if (!empty($values)) {
                // Check if $values is raw input or field data
                if (is_array($values) && count(array_intersect($fields, array_map('strtolower', array_keys($values)))) > 0) {
                    return $values;
                }
                $parameters[$field] = $values;
            }
        }
        
        if (isset($parameters['Aggregate']) && !isset($parameters['Aggregate']['Fields'])) {
            $parameters['Aggregate'] = [
                'Fields' => $parameters['Aggregate'],
            ];
        }
        
        return $parameters;
    }
}
