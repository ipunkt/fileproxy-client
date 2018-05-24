<?php

namespace Ipunkt\Fileproxy\Resources;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;

abstract class Resource
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var array
     */
    private $headers;

    /**
     * Resource constructor.
     * @param ClientInterface $client
     * @param string $baseUrl
     * @param array $headers
     */
    public function __construct(ClientInterface $client, $baseUrl, array $headers = array())
    {
        $this->client = $client;
        $this->baseUrl = $baseUrl;
        $this->headers = $headers;
    }

    /**
     * returns full url for resource
     *
     * @param string $baseUrl
     * @return string
     */
    abstract protected function url($baseUrl);

	/**
	 * returns an resource index via get
	 *
	 * @param array $headers
	 * @return \Psr\Http\Message\ResponseInterface
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
    protected function _index(array $headers = array())
    {
    	$request = new Request('GET',
            $this->url($this->baseUrl),
            $this->prepareHeaders($headers)
        );

        return $this->client->send($request);
    }

	/**
	 * returns a single resource via get
	 *
	 * @param string|integer $id
	 * @param array $headers
	 * @return \Psr\Http\Message\ResponseInterface
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
    protected function _get($id, array $headers = array())
    {
        $request = new Request('GET',
            $this->url($this->baseUrl) . '/' . $id,
            $this->prepareHeaders($headers)
        );

        return $this->client->send($request);
    }

	/**
	 * posts a message
	 *
	 * @param array $data
	 * @param array $headers
	 * @return \Psr\Http\Message\ResponseInterface
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
    protected function _post($data, array $headers = array())
    {
        $request = new Request('POST',
            $this->url($this->baseUrl),
            $this->prepareHeaders($headers),
            $this->prepareBody($data)
        );

        return $this->client->send($request);
    }

	/**
	 * puts a message
	 *
	 * @param string|integer $id
	 * @param array $data
	 * @param array $headers
	 * @return \Psr\Http\Message\ResponseInterface
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
    protected function _put($id, $data, array $headers = array())
    {
        $request = new Request('PUT',
            $this->url($this->baseUrl) . '/' . $id,
            $this->prepareHeaders($headers),
            $this->prepareBody($data)
        );

        return $this->client->send($request);
    }

	/**
	 * deletes a resource
	 *
	 * @param string|integer $id
	 * @param array $headers
	 * @return \Psr\Http\Message\ResponseInterface
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
    protected function _delete($id, array $headers = array())
    {
        $request = new Request('DELETE',
            $this->url($this->baseUrl) . '/' . $id,
            $this->prepareHeaders($headers)
        );

        return $this->client->send($request);
    }

    /**
     * create request model data
     *
     * @param string $type
     * @param array $data
     * @param string|int|null $id
     * @return array
     */
    protected function createRequestModel($type, array $data = array(), $id = null)
    {
        return array(
            'data' => array(
                'id' => $id,
                'type' => $type,
                'attributes' => $data,
            )
        );
    }

    /**
     * prepares body
     *
     * @param mixed $data
     * @return null|string
     */
    private function prepareBody($data)
    {
        if ($data === null) {
            return null;
        }

        return json_encode($data);
    }

    /**
     * prepares headers
     *
     * @param array $headers
     * @return array
     */
    private function prepareHeaders(array $headers)
    {
        $headers['Accept'] = 'application/vnd.api+json';
        $headers['Content-Type'] = 'application/vnd.api+json';

        return array_merge($this->headers, $headers);
    }
}