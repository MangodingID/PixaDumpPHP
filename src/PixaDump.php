<?php

namespace MangodingID\PixaDump;

use MangodingID\PixaDump\Client\GuzzleHttpClient;
use MangodingID\PixaDump\Contracts\HttpClient;

class PixaDump
{
    /**
     * @var bool
     */
    protected bool $silent = false;

    /**
     * @var HttpClient
     */
    protected HttpClient $client;

    /**
     * @param  string $host
     * @param  int    $port
     */
    public function __construct(string $host = 'localhost', int $port = 1337)
    {
        $this->client(new GuzzleHttpClient($host, $port));
    }

    /**
     * @return $this
     */
    public function silent() : PixaDump
    {
        $this->silent = true;

        return $this;
    }

    /**
     * @param  HttpClient $client
     * @return PixaDump
     */
    public function client(HttpClient $client) : PixaDump
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @param  mixed ...$args
     * @return PixaDump
     */
    public function dump(mixed ...$args) : PixaDump
    {
        foreach ($args as $arg) {
            $this->client->request('POST', 'dump', new PayloadFactory($arg));
        }

        return $this;
    }
}
