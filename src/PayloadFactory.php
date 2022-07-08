<?php

namespace MangodingID\PixaDump;

use Closure;
use MangodingID\PixaDump\Contracts\Payload;
use MangodingID\PixaDump\Exceptions\PixaDumpException;
use MangodingID\PixaDump\Payloads\ArrayPayload;
use MangodingID\PixaDump\Payloads\BooleanPayload;
use MangodingID\PixaDump\Payloads\DoublePayload;
use MangodingID\PixaDump\Payloads\FloatPayload;
use MangodingID\PixaDump\Payloads\IntegerPayload;
use MangodingID\PixaDump\Payloads\NullPayload;
use MangodingID\PixaDump\Payloads\StringPayload;
use Mockery;
use Mockery\MockInterface;

class PayloadFactory
{
    /**
     * @var array<string, class-string<Payload>>
     */
    protected array $payloads = [
        'null'    => NullPayload::class,
        'array'   => ArrayPayload::class,
        'float'   => FloatPayload::class,
        'double'  => DoublePayload::class,
        'string'  => StringPayload::class,
        'integer' => IntegerPayload::class,
        'boolean' => BooleanPayload::class,
    ];

    /**
     * @param  mixed $data
     */
    public function __construct(protected mixed $data)
    {
        //
    }

    /**
     * @param  string $type
     * @param  string $payload
     * @return PayloadFactory
     */
    public function register(string $type, string $payload) : PayloadFactory
    {
        $this->payloads[$type] = $payload;

        return $this;
    }

    /**
     * @return Payload
     * @throws PixaDumpException
     */
    public function create() : Payload
    {
        $type = strtolower(gettype($this->data));

        if (! isset($this->payloads[$type])) {
            throw new PixaDumpException(
                sprintf('Payload type "%s" is not supported.', $type)
            );
        }

        return new $this->payloads[$type]($this->data);
    }

    /**
     * @param  Closure<MockInterface>|null $closure
     * @return PayloadFactory
     * @throws PixaDumpException
     */
    public function mock(Closure $closure = null) : PayloadFactory
    {
        // @codeCoverageIgnoreStart
        if (! class_exists(Mockery::class)) {
            throw new PixaDumpException('Mockery is not installed');
        }
        // @codeCoverageIgnoreEnd

        $payload = Mockery::mock(get_class($this->create()), [$this->data]);

        if ($closure) {
            $closure($payload);
        }

        $payload->makePartial();

        $factory = Mockery::mock(PayloadFactory::class);
        $factory
            ->shouldReceive('create')
            ->andReturn($payload);

        return $factory;
    }
}
