<?php

namespace Ipunkt\Fileproxy\Resources;

use DateTime;
use InvalidArgumentException;
use Ipunkt\Fileproxy\Entities\Alias;
use Ipunkt\Fileproxy\Exceptions\ApiResponseException;

class FileAliasesResource extends Resource
{
    /**
     * @var string
     */
    private $reference;

    /**
     * sets reference
     *
     * @param string $reference
     * @return $this
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

	/**
	 * creates an alias
	 *
	 * @param string $path
	 * @param int $hits
	 * @param DateTime|null $validFrom
	 * @param DateTime|null $validUntil
	 * @return Alias
	 * @throws ApiResponseException
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
    public function create($path, $hits = 0, $validFrom = null, $validUntil = null)
    {
        $validFrom = $validFrom instanceof DateTime ? $validFrom->format(DateTime::ATOM) : null;
        $validUntil = $validUntil instanceof DateTime ? $validUntil->format(DateTime::ATOM) : null;

        $response = $this->_post($this->createRequestModel('aliases', array(
            'path' => $path,
            'hits' => intval($hits),
            'valid_from' => $validFrom,
            'valid_until' => $validUntil,
        )));

        if ($response->getStatusCode() === 200) {
            return Alias::fromResponse($response);
        }

        throw ApiResponseException::fromErrorResponse($response);
    }

	/**
	 * returns all aliases found
	 *
	 * @return array|Alias[]
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
    public function all()
    {
        $response = $this->_index();

        if ($response->getStatusCode() === 200) {
            return Alias::listFromResponse($response);
        }

        throw ApiResponseException::fromErrorResponse($response);
    }

    /**
     * returns full url for resource
     *
     * @param string $baseUrl
     * @return string
     * @throws InvalidArgumentException
     */
    protected function url($baseUrl)
    {
        if ($this->reference === null) {
            throw new InvalidArgumentException('Reference can not be null on first use');
        }

        return $baseUrl . 'api/files/' . $this->reference . '/aliases';
    }
}