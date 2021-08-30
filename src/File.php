<?php

/*
 * This file is part of the fw4/whise-api library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Whise\Api;

use Whise\Api\ApiAdapter\ApiAdapter;

class File
{
    /** @var resource */
    protected $file;

    /** @var array */
    protected $metadata;

    /**
     * @param string|SplFileInfo|resource File path string, or SplFileInfo
     * object, or file handle resource
     * @param array $metadata Associative array containing request parameters
     * relating to this file
     * @param string|null $filename Filename string, or null to use local
     * filename from path
     */
    public function __construct($file, array $metadata = [], ?string $filename = null)
    {
        if (isset($filename)) {
            $metadata['file'] = trim($filename);
        }
        if (is_string($file)) {
            if (empty($metadata['file'])) {
                $metadata['file'] = pathinfo($file, PATHINFO_BASENAME);
            }
            $file = fopen($file, 'r');
        } elseif ($file instanceof \SplFileInfo) {
            if (empty($metadata['file'])) {
                $metadata['file'] = $file->getBasename();
            }
            $file = fopen($file->getPath(), 'r');
        } elseif (!is_resource($file)) {
            throw new \InvalidArgumentException('Whise\Api\File expects file path, resource or SplFileInfo.');
        }

        $this->file = $file;
        $this->metadata = $metadata;
    }

    public function __destruct()
    {
        if (is_resource($this->file)) {
            fclose($this->file);
        }
    }

    /**
     * Get file handle resource.
     *
     * @return resource
     */
    public function getFileResource()
    {
        return $this->file;
    }

    /**
     * Get associative array containing request parameters relating to this
     * file.
     *
     * @return array
     */
    public function getMetadata(): array
    {
        return $this->metadata;
    }
}
