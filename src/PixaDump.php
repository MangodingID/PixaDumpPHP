<?php

namespace MangodingID\PixaDump;

use MangodingID\PixaDump\Client\GuzzleHttpClient;
use MangodingID\PixaDump\Contracts\HttpClient;
use Throwable;

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
    public function secure() : PixaDump
    {
        $this->client->secure();

        return $this;
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
     * @throws Throwable
     */
    public function dump(mixed ...$args) : PixaDump
    {
        foreach ($args as $arg) {
            try {
                $this->client->request('POST', 'dump', new PayloadFactory($arg));
            } catch (Throwable $exception) {
                if (! $this->silent) {
                    throw $exception;
                }
            }
        }

        return $this;
    }
}
