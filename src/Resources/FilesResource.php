<?php

namespace Ipunkt\Fileproxy\Resources;

use Ipunkt\Fileproxy\Entities\File;
use Ipunkt\Fileproxy\Exceptions\ApiResponseException;

class FilesResource extends Resource
{
	/**
	 * stores a single file resource
	 *
	 * @param \SplFileInfo $file
	 * @return File
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
    public function store(\SplFileInfo $file)
    {
        $response = $this->_post($this->createRequestModel('files', array(
            'type' => 'attachment',
            'source' => base64_encode(file_get_contents($file->getRealPath())),
            'filename' => $file->getBasename(),
        )));

        if ($response->getStatusCode() === 201) {
            return File::fromResponse($response);
        }

        throw ApiResponseException::fromErrorResponse($response);
    }

	/**
	 * stores a remote url as proxy file
	 *
	 * @param string $url
	 * @return File
	 * @throws ApiResponseException
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
    public function storeRemote($url)
    {
        $response = $this->_post($this->createRequestModel('files', array(
            'type' => 'uri',
            'source' => $url,
        )));

        if ($response->getStatusCode() === 201) {
            return File::fromResponse($response);
        }

        throw ApiResponseException::fromErrorResponse($response);
    }

	/**
	 * updates a single file resource
	 *
	 * @param string $reference
	 * @param \SplFileInfo $file
	 * @return File
	 * @throws ApiResponseException
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
    public function update($reference, \SplFileInfo $file)
    {
        $response = $this->_put($reference, $this->createRequestModel('files', array(
            'type' => 'attachment',
            'source' => base64_encode(file_get_contents($file->getRealPath())),
            'filename' => $file->getBasename(),
        )));

        if ($response->getStatusCode() === 201) {
            return File::fromResponse($response);
        }

        throw ApiResponseException::fromErrorResponse($response);
    }

	/**
	 * update a remote url as proxy file
	 *
	 * @param string $reference
	 * @param string $url
	 * @return File
	 * @throws ApiResponseException
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
    public function updateRemote($reference, $url)
    {
        $response = $this->_put($reference, $this->createRequestModel('files', array(
            'type' => 'uri',
            'source' => $url,
        )));

        if ($response->getStatusCode() === 201) {
            return File::fromResponse($response);
        }

        throw ApiResponseException::fromErrorResponse($response);
    }

	/**
	 * returns a single files resource
	 *
	 * @param string $reference
	 * @return File
	 * @throws ApiResponseException
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
    public function get($reference)
    {
        $response = $this->_get($reference);

        if ($response->getStatusCode() === 200) {
            return File::fromResponse($response);
        }

        throw ApiResponseException::fromErrorResponse($response);
    }

    /**
     *
     *
     * @param $baseUrl
     * @return string
     */
    protected function url($baseUrl)
    {
        return $baseUrl . 'api/files';
    }
}
