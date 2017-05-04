<?php

namespace Ipunkt\Fileproxy\Entities;

use Guzzle\Http\Message\Response;

class File
{
    /**
     * @var string
     */
    private $reference;
    /**
     * @var string
     */
    private $filename;
    /**
     * @var int
     */
    private $size;
    /**
     * @var string
     */
    private $checksum;
    /**
     * @var string
     */
    private $mimetype;
    /**
     * @var int
     */
    private $hits;

    /**
     * returns file entity from api response
     *
     * @param Response $response
     * @return static
     * @throws \Guzzle\Common\Exception\RuntimeException
     */
    public static function fromResponse(Response $response)
    {
        $data = $response->json();

        $reference = array_get($data, 'data.id');
        $filename = array_get($data, 'data.attributes.filename');
        $size = array_get($data, 'data.attributes.size', 0);
        $checksum = array_get($data, 'data.attributes.checksum');
        $mimetype = array_get($data, 'data.attributes.mimetype');
        $hits = array_get($data, 'data.attributes.hits', 0);

        return new static($reference, $filename, $size, $checksum, $mimetype, $hits);
    }

    /**
     * File constructor.
     * @param string $reference
     * @param string $filename
     * @param integer $size
     * @param string $checksum
     * @param string $mimetype
     * @param integer $hits
     */
    public function __construct($reference, $filename, $size, $checksum, $mimetype, $hits)
    {
        $this->reference = $reference;
        $this->filename = $filename;
        $this->size = $size;
        $this->checksum = $checksum;
        $this->mimetype = $mimetype;
        $this->hits = $hits;
    }

    /**
     * returns Reference
     *
     * @return string
     */
    public function reference()
    {
        return $this->reference;
    }

    /**
     * returns Filename
     *
     * @return string
     */
    public function filename()
    {
        return $this->filename;
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
     * returns Checksum
     *
     * @return string
     */
    public function checksum()
    {
        return $this->checksum;
    }

    /**
     * returns Mimetype
     *
     * @return string
     */
    public function mimetype()
    {
        return $this->mimetype;
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