<?php

namespace Ipunkt\Fileproxy\Entities;

use Psr\Http\Message\ResponseInterface;

class Alias
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $path;
    /**
     * @var \DateTime|null
     */
    private $validFrom;
    /**
     * @var \DateTime|null
     */
    private $validUntil;
    /**
     * @var int|null
     */
    private $hits;
    /**
     * @var int|null
     */
    private $hitsLeft;
    /**
     * @var int|null
     */
    private $hitsTotal;
    /**
     * @var string
     */
    private $download;

    /**
     * Alias constructor.
     * @param string $id
     * @param string $path
     * @param \DateTime|null $validFrom
     * @param \DateTime|null $validUntil
     * @param integer|null $hits
     * @param integer|null $hitsLeft
     * @param integer|null $hitsTotal
     * @param string $download
     */
    public function __construct($id, $path, $validFrom, $validUntil, $hits, $hitsLeft, $hitsTotal, $download)
    {
        $this->id = $id;
        $this->path = $path;
        $this->validFrom = $validFrom;
        $this->validUntil = $validUntil;
        $this->hits = $hits;
        $this->hitsLeft = $hitsLeft;
        $this->hitsTotal = $hitsTotal;
        $this->download = $download;
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

        $id = array_get($data, 'data.id');
        $path = array_get($data, 'data.attributes.path');
        $from = array_get($data, 'data.attributes.valid_from');
        $validFrom = empty($from) ? null : \DateTime::createFromFormat(\DateTime::ATOM, $from);
        $until = array_get($data, 'data.attributes.valid_until');
        $validUntil = empty($until) ? null : \DateTime::createFromFormat(\DateTime::ATOM, $until);
        $hits = array_get($data, 'data.attributes.hits', 0);
        $hitsLeft = array_get($data, 'data.attributes.hits_left');
        $hitsTotal = array_get($data, 'data.attributes.hits_total');
        $download = array_get($data, 'data.links.download');

        return new static($id, $path, $validFrom, $validUntil, $hits, $hitsLeft, $hitsTotal, $download);
    }

	/**
	 * returns a list of Alias instances from response
	 *
	 * @param ResponseInterface $response
	 * @return array|Alias[]
	 */
    public static function listFromResponse(ResponseInterface $response)
    {
        $data = json_decode( $response->getBody(), true );
        $list = array_get($data, 'data', array());
        if (!is_array($list)) {
            $list = array();
        }

        $aliases = array();
        foreach ($list as $item) {
            $id = array_get($item, 'id');
            $path = array_get($item, 'attributes.path');
            $from = array_get($item, 'attributes.valid_from');
            $validFrom = empty($from) ? null : \DateTime::createFromFormat(\DateTime::ATOM, $from);
            $until = array_get($item, 'attributes.valid_until');
            $validUntil = empty($until) ? null : \DateTime::createFromFormat(\DateTime::ATOM, $until);
            $hits = array_get($item, 'attributes.hits', 0);
            $hitsLeft = array_get($item, 'attributes.hits_left');
            $hitsTotal = array_get($item, 'attributes.hits_total');
            $download = array_get($item, 'links.download');

            $aliases[] = new static($id, $path, $validFrom, $validUntil, $hits, $hitsLeft, $hitsTotal, $download);
        }

        return $aliases;
    }

    /**
     * returns Id
     *
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * returns Reference
     *
     * @return string
     */
    public function reference()
    {
        list($reference,) = explode('.', $this->id());

        return $reference;
    }

    /**
     * returns Path
     *
     * @return string
     */
    public function path()
    {
        return $this->path;
    }

    /**
     * returns ValidFrom
     *
     * @return \DateTime|null
     */
    public function validFrom()
    {
        return $this->validFrom;
    }

    /**
     * returns ValidUntil
     *
     * @return \DateTime|null
     */
    public function validUntil()
    {
        return $this->validUntil;
    }

    /**
     * returns Hits
     *
     * @return int|null
     */
    public function hits()
    {
        return $this->hits;
    }

    /**
     * returns HitsLeft
     *
     * @return int|null
     */
    public function hitsLeft()
    {
        return $this->hitsLeft;
    }

    /**
     * returns HitsTotal
     *
     * @return int|null
     */
    public function hitsTotal()
    {
        return $this->hitsTotal;
    }

    /**
     * returns Download url
     *
     * @return string
     */
    public function downloadUrl()
    {
        return $this->download;
    }
}