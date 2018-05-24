<?php

namespace Ipunkt\Fileproxy\Resources;

use Ipunkt\Fileproxy\Entities\Alias;
use Ipunkt\Fileproxy\Exceptions\ApiResponseException;

class AliasesResource extends Resource
{
	/**
	 * returns a single alias by combined alias id
	 *
	 * @param string $aliasId
	 * @return Alias
	 * @throws ApiResponseException
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
    public function get($aliasId)
    {
        $response = $this->_get($aliasId);

        if ($response->getStatusCode() === 200) {
            return Alias::fromResponse($response);
        }

        throw ApiResponseException::fromErrorResponse($response);
    }

	/**
	 * deletes an alias
	 *
	 * @param string $aliasId
	 * @return bool
	 * @throws ApiResponseException
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
    public function delete($aliasId)
    {
        $response = $this->_delete($aliasId);

        if ($response->getStatusCode() === 204) {
            return true;
        }

        throw ApiResponseException::fromErrorResponse($response);
    }

    /**
     * returns full url for resource
     *
     * @param string $baseUrl
     * @return string
     */
    protected function url($baseUrl)
    {
        return $baseUrl . 'api/aliases';
    }
}