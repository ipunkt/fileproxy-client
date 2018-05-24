<?php

namespace Ipunkt\Fileproxy;

use Guzzle\Http\ClientInterface;
use Ipunkt\Fileproxy\Resources\AliasesResource;
use Ipunkt\Fileproxy\Resources\FileAliasesResource;
use Ipunkt\Fileproxy\Resources\FilesResource;
use Ipunkt\Fileproxy\Resources\StatisticsResource;

class FileproxyClient
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var string
     */
    private $host;

    /**
     * @var FilesResource
     */
    private $filesResource;

    /**
     * @var FileAliasesResource
     */
    private $fileAliasesResource;

    /**
     * @var AliasesResource
     */
    private $aliasResource;

    /**
     * @var StatisticsResource
     */
    private $statisticsResource;

    /**
     * @var array
     */
    private $headers = array();

    /**
     * FileproxyClient constructor.
     * @param string $host
     * @param ClientInterface $client
     */
    public function __construct($host, ClientInterface $client)
    {
        $this->client = $client;
        $this->client->setBaseUrl($host);
        $this->host = rtrim($host, '/') . '/';
    }

    /**
     * set credentials for requesting the api
     *
     * @param string $secretToken
     * @param null|string $secretHeaderName
     * @return $this
     */
    public function setCredentials($secretToken, $secretHeaderName = null)
    {
        if (isset($this->headers['X-FILEPROXY-TOKEN'])) {
            unset($this->headers['X-FILEPROXY-TOKEN']);
        }

        if ($secretHeaderName === null) {
            $secretHeaderName = 'X-FILEPROXY-TOKEN';
        }
        $this->addHeader($secretHeaderName, $secretToken);

        return $this;
    }

    /**
     * adds a header for each resource request
     *
     * @param string $name
     * @param string $value
     * @return $this
     */
    public function addHeader($name, $value)
    {
        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * files resource
     *
     * @return FilesResource
     */
    public function files()
    {
        if ($this->filesResource === null) {
            $this->filesResource = new FilesResource($this->client(), $this->host, $this->headers);
        }
        return $this->filesResource;
    }

    /**
     * file aliases resource
     *
     * @param null $reference
     * @return FileAliasesResource
     */
    public function fileAliases($reference = null)
    {
        if ($this->fileAliasesResource === null) {
            $this->fileAliasesResource = new FileAliasesResource($this->client(), $this->host, $this->headers);
        }

        if ($reference !== null) {
            $this->fileAliasesResource->setReference($reference);
        }

        return $this->fileAliasesResource;
    }

    /**
     * alias resource
     *
     * @return AliasesResource
     */
    public function alias()
    {
        if ($this->aliasResource === null) {
            $this->aliasResource = new AliasesResource($this->client(), $this->host, $this->headers);
        }
        return $this->aliasResource;
    }

    /**
     * statistics resource
     *
     * @return StatisticsResource
     */
    public function statistics()
    {
        if ($this->statisticsResource === null) {
            $this->statisticsResource = new StatisticsResource($this->client(), $this->host, $this->headers);
        }
        return $this->statisticsResource;
    }

    /**
     * returns client
     *
     * @return ClientInterface
     */
    protected function client()
    {
        return $this->client;
    }
}