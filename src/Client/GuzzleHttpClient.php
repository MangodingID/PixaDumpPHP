<?php

namespace MangodingID\PixaDump\Client;

use GuzzleHttp\Client;
use MangodingID\PixaDump\Exceptions\PixaDumpException;
use MangodingID\PixaDump\PayloadFactory;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class GuzzleHttpClient extends HttpClient
{
    /**
     * @var Client
     */
    protected Client $client;

    /**
     * @param  string $host
     * @param  int    $port
     */
    public function __construct(string $host, int $port)
    {
        parent::__construct($host, $port);

        $this->client = new Client([
            //
        ]);
    }

    /**
     * @param  string         $method
     * @param  string         $path
     * @param  PayloadFactory $factory
     * @param  array          $headers
     * @return ResponseInterface|bool
     * @throws PixaDumpException
     */
    public function request(string $method, string $path, PayloadFactory $factory, array $headers = []) : bool|ResponseInterface
    {
        try {
            return $this->client->request($method, $this->buildURL($path), [
                'verify'  => false,
                'headers' => $this->getHeaders($headers),
                'body'    => $factory->create()->toJson(),
            ]);
        } catch (Throwable $exception) {
            throw new PixaDumpException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}
