<?php

namespace MangodingID\PixaDump\Tests\Client;

use MangodingID\PixaDump\Client\GuzzleHttpClient;
use MangodingID\PixaDump\Client\HttpClient;
use MangodingID\PixaDump\Exceptions\PixaDumpException;
use MangodingID\PixaDump\PayloadFactory;
use PHPUnit\Framework\TestCase;

class GuzzleHttpClientTest extends TestCase
{
    /**
     * @var HttpClient
     */
    protected HttpClient $client;

    /**
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this->client = new GuzzleHttpClient('localhost', 1337);
    }

    /**
     * @return void
     */
    public function testItReturnBaseUriWithHttpScheme() : void
    {
        $this->assertEquals('http://localhost:1337/foo', $this->client->buildURL(
            'foo'
        ));
    }

    /**
     * @return void
     */
    public function testItCanOverrideHost() : void
    {
        $this->client->setHost('example.com');

        $this->assertEquals('http://example.com:1337/foo', $this->client->buildURL(
            'foo'
        ));
    }

    /**
     * @return void
     */
    public function testItCanOverridePort() : void
    {
        $this->client->setPort(3000);

        $this->assertEquals('http://localhost:3000/foo', $this->client->buildURL(
            'foo'
        ));
    }

    /**
     * @return void
     */
    public function testHeadersContainEssentialHeaders() : void
    {
        $this->assertArrayHasKey('Accept', $this->client->getHeaders());
        $this->assertArrayHasKey('Content-Type', $this->client->getHeaders());
        $this->assertArrayHasKey('X-Request-From', $this->client->getHeaders());
    }

    /**
     * @return void
     * @throws PixaDumpException
     */
    public function testItCanThrowExceptionWhenRequestIsFail() : void
    {
        $this->expectException(PixaDumpException::class);
        $this->expectExceptionMessage('It looks like PixaDump is not opening, to ignore this message, use silent mode.');

        $client = $this->createPartialMock(GuzzleHttpClient::class, [
            'request',
        ]);

        $client
            ->method('request')
            ->willThrowException(
                new PixaDumpException('It looks like PixaDump is not opening, to ignore this message, use silent mode.')
            );

        $client->request('POST', 'dump', new PayloadFactory('foo'));
    }
}
