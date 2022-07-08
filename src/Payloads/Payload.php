<?php

namespace MangodingID\PixaDump\Payloads;

use Carbon\Carbon;
use JetBrains\PhpStorm\ArrayShape;
use MangodingID\PixaDump\Contracts\Payload as Contract;
use Ramsey\Uuid\Uuid;

abstract class Payload implements Contract
{
    protected mixed $data = '';

    /**
     * @param  mixed $data
     */
    public function __construct(mixed $data)
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getUUID() : string
    {
        return Uuid::uuid4();
    }

    /**
     * @return string
     */
    public function getTime() : string
    {
        return Carbon::now()->toDateTimeString();
    }

    /**
     * @return string
     */
    public function getFill() : string
    {
        $fills = [
            'indigo', 'emerald', 'sky', 'orange', 'rose',
        ];

        return $fills[array_rand($fills)];
    }

    /**
     * @return array
     */
    #[ArrayShape([
        'data' => "array",
        'type' => "string",
        'time' => "string",
        'uuid' => "string",
        'fill' => "string",
    ])]
    public function toArray() : array
    {
        return [
            'data' => $this->getData(),
            'type' => $this->getType(),
            'uuid' => $this->getUUID(),
            'time' => $this->getTime(),
            'fill' => $this->getFill(),
        ];
    }

    /**
     * @param  int $options
     * @return string
     */
    public function toJson(int $options = 0) : string
    {
        return json_encode($this->toArray(), $options);
    }
}
