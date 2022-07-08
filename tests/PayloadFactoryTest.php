<?php

namespace MangodingID\PixaDump\Tests;

use Carbon\Carbon;
use MangodingID\PixaDump\Exceptions\PixaDumpException;
use MangodingID\PixaDump\PayloadFactory;
use MangodingID\PixaDump\Payloads\ArrayPayload;
use MangodingID\PixaDump\Payloads\BooleanPayload;
use MangodingID\PixaDump\Payloads\DoublePayload;
use MangodingID\PixaDump\Payloads\IntegerPayload;
use MangodingID\PixaDump\Payloads\NullPayload;
use MangodingID\PixaDump\Payloads\StringPayload;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class PayloadFactoryTest extends TestCase
{
    /**
     * @var string
     */
    protected string $time;

    /**
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        Carbon::setTestNow(
            $this->time = '2022-01-01 00:00:00'
        );
    }

    /**
     * @return void
     * @throws PixaDumpException
     */
    public function testItCanCreatePayloadFromString() : void
    {
        $factory = new PayloadFactory('foo');

        $factory = $factory->mock(function (MockInterface $payload) {
            $payload
                ->shouldReceive('getUUID')
                ->andReturn('be1b3a20-ad0d-46de-bcb1-984e75bc1254');

            $payload
                ->shouldReceive('getFill')
                ->andReturn('orange');
        });

        $this->assertInstanceOf(StringPayload::class, $factory->create());

        $expected = [
            'type' => 'string',
            'time' => $this->time,
            'uuid' => 'be1b3a20-ad0d-46de-bcb1-984e75bc1254',
            'fill' => 'orange',
            'data' => [
                'label' => 'string',
                'value' => 'foo',
            ],
        ];

        $this->assertEquals($expected, $factory->create()->toArray());
    }

    /**
     * @return void
     * @throws PixaDumpException
     */
    public function testItCanCreatePayloadFromInteger() : void
    {
        $factory = new PayloadFactory(123);

        $factory = $factory->mock(function (MockInterface $payload) {
            $payload
                ->shouldReceive('getUUID')
                ->andReturn('be1b3a20-ad0d-46de-bcb1-984e75bc1254');

            $payload
                ->shouldReceive('getFill')
                ->andReturn('orange');
        });

        $this->assertInstanceOf(IntegerPayload::class, $factory->create());

        $expected = [
            'type' => 'integer',
            'time' => $this->time,
            'uuid' => 'be1b3a20-ad0d-46de-bcb1-984e75bc1254',
            'fill' => 'orange',
            'data' => [
                'label' => 'integer',
                'value' => 123,
            ],
        ];

        $this->assertEquals($expected, $factory->create()->toArray());
    }

    /**
     * @return void
     * @throws PixaDumpException
     */
    public function testItCanCreatePayloadFromFloat() : void
    {
        $factory = new PayloadFactory(123.45);

        $factory = $factory->mock(function (MockInterface $payload) {
            $payload
                ->shouldReceive('getUUID')
                ->andReturn('be1b3a20-ad0d-46de-bcb1-984e75bc1254');

            $payload
                ->shouldReceive('getFill')
                ->andReturn('orange');
        });

        $this->assertInstanceOf(DoublePayload::class, $factory->create());

        $expected = [
            'type' => 'float',
            'time' => $this->time,
            'uuid' => 'be1b3a20-ad0d-46de-bcb1-984e75bc1254',
            'fill' => 'orange',
            'data' => [
                'label' => 'float',
                'value' => 123.45,
            ],
        ];

        $this->assertEquals($expected, $factory->create()->toArray());
    }

    /**
     * @return void
     * @throws PixaDumpException
     */
    public function testItCanCreatePayloadFromBoolean() : void
    {
        $factory = new PayloadFactory(true);

        $factory = $factory->mock(function (MockInterface $payload) {
            $payload
                ->shouldReceive('getUUID')
                ->andReturn('be1b3a20-ad0d-46de-bcb1-984e75bc1254');

            $payload
                ->shouldReceive('getFill')
                ->andReturn('orange');
        });

        $this->assertInstanceOf(BooleanPayload::class, $factory->create());

        $expected = [
            'type' => 'boolean',
            'time' => $this->time,
            'uuid' => 'be1b3a20-ad0d-46de-bcb1-984e75bc1254',
            'fill' => 'orange',
            'data' => [
                'label' => 'boolean',
                'value' => true,
            ],
        ];

        $this->assertEquals($expected, $factory->create()->toArray());
    }

    /**
     * @return void
     * @throws PixaDumpException
     */
    public function testItCanCreatePayloadFromNull() : void
    {
        $factory = new PayloadFactory(null);

        $factory = $factory->mock(function (MockInterface $payload) {
            $payload
                ->shouldReceive('getUUID')
                ->andReturn('be1b3a20-ad0d-46de-bcb1-984e75bc1254');

            $payload
                ->shouldReceive('getFill')
                ->andReturn('orange');
        });

        $this->assertInstanceOf(NullPayload::class, $factory->create());

        $expected = [
            'type' => 'null',
            'time' => $this->time,
            'uuid' => 'be1b3a20-ad0d-46de-bcb1-984e75bc1254',
            'fill' => 'orange',
            'data' => [
                'label' => 'null',
                'value' => null,
            ],
        ];

        $this->assertEquals($expected, $factory->create()->toArray());
    }

    /**
     * @return void
     * @throws PixaDumpException
     */
    public function testItCanCreatePayloadFromArray() : void
    {
        $factory = new PayloadFactory([
            'foo' => 'bar',
            'bar' => 'baz',
        ]);

        $factory = $factory->mock(function (MockInterface $payload) {
            $payload
                ->shouldReceive('getUUID')
                ->andReturn('be1b3a20-ad0d-46de-bcb1-984e75bc1254');

            $payload
                ->shouldReceive('getFill')
                ->andReturn('orange');
        });

        $this->assertInstanceOf(ArrayPayload::class, $factory->create());

        $expected = [
            'type' => 'array',
            'time' => $this->time,
            'uuid' => 'be1b3a20-ad0d-46de-bcb1-984e75bc1254',
            'fill' => 'orange',
            'data' => [
                'label' => 'array',
                'value' => [
                    'foo' => 'bar',
                    'bar' => 'baz',
                ],
            ],
        ];

        $this->assertEquals($expected, $factory->create()->toArray());
    }
}
