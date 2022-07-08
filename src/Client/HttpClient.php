<?php

namespace MangodingID\PixaDump\Client;

use MangodingID\PixaDump\Contracts\HttpClient as Contract;

abstract class HttpClient implements Contract
{
    /**
     * @var bool
     */
    protected bool $secure = false;

    /**
     * @param  string $host
     * @param  int    $port
     */
    public function __construct(protected string $host, protected int $port)
    {
        //
    }

    /**
     * @return Contract
     */
    public function secure() : Contract
    {
        $this->secure = true;

        return $this;
    }

    /**
     * @param  string $host
     * @return $this
     */
    public function setHost(string $host) : HttpClient
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @param  int $port
     * @return $this
     */
    public function setPort(int $port) : HttpClient
    {
        $this->port = $port;

        return $this;
    }

    /**
     * @param  string $path
     * @return string
     */
    public function buildURL(string $path) : string
    {
        if ($this->secure) {
            return sprintf('https://%s:%d/api/%s', $this->host, $this->port, $path);
        }

        return sprintf('http://%s:%d/api/%s', $this->host, $this->port, $path);
    }

    /**
     * @param  array $headers
     * @return array
     */
    public function getHeaders(array $headers = []) : array
    {
        if (! isset($headers['X-Request-From'])) {
            $headers['X-Request-From'] = 'PIXADUMP/PHP';
        }

        if (isset($headers['X-Request-From'])) {
            $headers['X-Request-From'] = strtoupper($headers['X-Request-From']); // Make sure it's uppercase
        }

        return array_merge($headers, [
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
        ]);
    }
}
