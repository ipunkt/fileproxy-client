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
     * files resource
     *
     * @return FilesResource
     */
    public function files()
    {
        if ($this->filesResource === null) {
            $this->filesResource = new FilesResource($this->client(), $this->host);
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
            $this->fileAliasesResource = new FileAliasesResource($this->client(), $this->host);
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
            $this->aliasResource = new AliasesResource($this->client(), $this->host);
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
            $this->statisticsResource = new StatisticsResource($this->client(), $this->host);
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