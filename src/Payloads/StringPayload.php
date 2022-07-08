<?php

namespace MangodingID\PixaDump\Payloads;

use JetBrains\PhpStorm\ArrayShape;

class StringPayload extends Payload
{
    /**
     * @param  string $data
     */
    public function __construct(string $data)
    {
        parent::__construct($data);
    }

    /**
     * @return string
     */
    public function getType() : string
    {
        return 'string';
    }

    /**
     * @return array
     */
    #[ArrayShape([
        'label' => "string", 'value' => "mixed",
    ])]
    public function getData() : array
    {
        return [
            'label' => 'string',
            'value' => $this->data,
        ];
    }
}
