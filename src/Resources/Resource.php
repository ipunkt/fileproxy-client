<?php

namespace Ipunkt\Fileproxy\Resources;

use Guzzle\Http\ClientInterface;

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
     * Resource constructor.
     * @param ClientInterface $client
     * @param string $baseUrl
     */
    public function __construct(ClientInterface $client, $baseUrl)
    {
        $this->client = $client;
        $this->baseUrl = $baseUrl;
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
     * @return \Guzzle\Http\Message\Response
     * @throws \Guzzle\Http\Exception\RequestException
     */
    protected function _index(array $headers = array())
    {
        $request = $this->client->get(
            $this->url($this->baseUrl),
            $this->prepareHeaders($headers)
        );

        return $request->send();
    }

    /**
     * returns a single resource via get
     *
     * @param string|integer $id
     * @param array $headers
     * @return \Guzzle\Http\Message\Response
     * @throws \Guzzle\Http\Exception\RequestException
     */
    protected function _get($id, array $headers = array())
    {
        $request = $this->client->get(
            $this->url($this->baseUrl) . '/' . $id,
            $this->prepareHeaders($headers)
        );

        return $request->send();
    }

    /**
     * posts a message
     *
     * @param array $data
     * @param array $headers
     * @return \Guzzle\Http\Message\Response
     * @throws \Guzzle\Http\Exception\RequestException
     */
    protected function _post($data, array $headers = array())
    {
        $request = $this->client->post(
            $this->url($this->baseUrl),
            $this->prepareHeaders($headers),
            $this->prepareBody($data)
        );

        return $request->send();
    }

    /**
     * deletes a resource
     *
     * @param string|integer $id
     * @param array $headers
     * @return \Guzzle\Http\Message\Response
     * @throws \Guzzle\Http\Exception\RequestException
     */
    protected function _delete($id, array $headers = array())
    {
        $request = $this->client->delete(
            $this->url($this->baseUrl) . '/' . $id,
            $this->prepareHeaders($headers)
        );

        return $request->send();
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

        return $headers;
    }
}