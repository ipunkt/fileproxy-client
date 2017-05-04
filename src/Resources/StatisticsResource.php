<?php

namespace Ipunkt\Fileproxy\Resources;

use Ipunkt\Fileproxy\Entities\Statistic;
use Ipunkt\Fileproxy\Exceptions\ApiResponseException;

class StatisticsResource extends Resource
{
    /**
     * returns service statistics
     *
     * @return Statistic
     * @throws \Guzzle\Common\Exception\RuntimeException
     * @throws \Guzzle\Http\Exception\RequestException
     * @throws ApiResponseException
     */
    public function stats()
    {
        $response = $this->_index();

        if ($response->getStatusCode() === 200) {
            return Statistic::fromResponse($response);
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
        return $baseUrl . 'api/statistics';
    }
}