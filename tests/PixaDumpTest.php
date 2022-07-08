<?php

namespace MangodingID\PixaDump\Tests;

use Carbon\Carbon;
use MangodingID\PixaDump\Client\GuzzleHttpClient;
use MangodingID\PixaDump\Exceptions\PixaDumpException;
use MangodingID\PixaDump\PayloadFactory;
use MangodingID\PixaDump\PixaDump;
use PHPUnit\Framework\TestCase;
use Throwable;

class PixaDumpTest extends TestCase
{
    /**
     * @var string
     */
    protected string $time;

    /**
     * @var PixaDump
     */
    protected PixaDump $pixadump;

    /**
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        Carbon::setTestNow(
            $this->time = '2022-01-01 00:00:00'
        );

        $this->pixadump = new PixaDump('localhost', 1337);
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function testItCanSendPayloadToPixaDump() : void
    {
        $client = $this->createMock(GuzzleHttpClient::class);
        $client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('POST'),
                $this->equalTo('dump'),
                $this->equalTo(
                    new PayloadFactory('foo')
                )
            );

        $this->pixadump->client($client)->dump('foo');
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function testDontThrowExceptionWhenInSilentMode() : void
    {
        $client = $this->createPartialMock(GuzzleHttpClient::class, [
            'request',
        ]);

        $client
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('POST'),
                $this->equalTo('dump'),
                $this->equalTo(
                    new PayloadFactory('foo')
                )
            )
            ->willThrowException(new PixaDumpException(
                'It looks like PixaDump is not opening, to ignore this message, use silent mode.'
            ));

        $this->pixadump->client($client)->silent()->dump('foo');
    }
}
