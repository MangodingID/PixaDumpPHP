<?php

namespace MangodingID\PixaDump\Contracts;

use MangodingID\PixaDump\PayloadFactory;
use Psr\Http\Message\ResponseInterface;

interface HttpClient
{
    /**
     * @param  string $host
     * @param  int    $port
     */
    public function __construct(string $host, int $port);

    /**
     * @param  string $host
     * @return $this
     */
    public function setHost(string $host) : self;

    /**
     * @param  int $port
     * @return $this
     */
    public function setPort(int $port) : self;

    /**
     * @return array
     */
    public function getHeaders() : array;

    /**
     * @param  string         $method
     * @param  string         $path
     * @param  PayloadFactory $factory
     * @param  array          $headers
     * @return ResponseInterface|bool
     */
    public function request(string $method, string $path, PayloadFactory $factory, array $headers = []) : ResponseInterface|bool;
}
