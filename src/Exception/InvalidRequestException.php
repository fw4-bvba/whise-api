<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api\Exception;

use Throwable;

class InvalidRequestException extends \Exception
{
    /**  @var array<string> */
    private array $validationCodes = [];

    public function __construct(
        string $message = '',
        array $validationCodes = [],
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->addValidationCode(...$validationCodes);
    }

    /**
     * Add one or more validation codes that indicate validation errors.
     *
     * @param string $code
     */
    public function addValidationCode(string ...$code)
    {
        $this->validationCodes = array_merge($this->validationCodes, $code);
    }

    /**
     * Get any error codes indicating validation issues.
     *
     * @return array<string>
     */
    public function getValidationCodes(): array
    {
        return $this->validationCodes;
    }
}
