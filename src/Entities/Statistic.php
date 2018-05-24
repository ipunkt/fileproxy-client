<?php

namespace Ipunkt\Fileproxy\Entities;

use Psr\Http\Message\ResponseInterface;

class Statistic
{
    /**
     * @var int
     */
    private $size;
    /**
     * @var int
     */
    private $files;
    /**
     * @var int
     */
    private $aliases;
    /**
     * @var int
     */
    private $hits;

    /**
     * Statistic constructor.
     * @param int $size
     * @param int $files
     * @param int $aliases
     * @param int $hits
     */
    public function __construct($size, $files, $aliases, $hits)
    {
        $this->size = $size;
        $this->files = $files;
        $this->aliases = $aliases;
        $this->hits = $hits;
    }

	/**
	 * returns file entity from api response
	 *
	 * @param ResponseInterface $response
	 * @return static
	 */
    public static function fromResponse(ResponseInterface $response)
    {
        $data = json_decode( $response->getBody(), true );

        $size = array_get($data, 'data.attributes.size', 0);
        $files = array_get($data, 'data.attributes.files', 0);
        $aliases = array_get($data, 'data.attributes.aliases', 0);
        $hits = array_get($data, 'data.attributes.hits', 0);

        return new static($size, $files, $aliases, $hits);
    }

    /**
     * returns Size
     *
     * @return int
     */
    public function size()
    {
        return $this->size;
    }

    /**
     * returns Files
     *
     * @return int
     */
    public function files()
    {
        return $this->files;
    }

    /**
     * returns Aliases
     *
     * @return int
     */
    public function aliases()
    {
        return $this->aliases;
    }

    /**
     * returns Hits
     *
     * @return int
     */
    public function hits()
    {
        return $this->hits;
    }
}