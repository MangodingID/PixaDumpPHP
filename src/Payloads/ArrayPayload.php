<?php

namespace MangodingID\PixaDump\Payloads;

use JetBrains\PhpStorm\ArrayShape;

class ArrayPayload extends Payload
{
    /**
     * @return string
     */
    public function getType() : string
    {
        return 'array';
    }

    /**
     * @inheritDoc
     */
    #[ArrayShape([
        'label' => "string",
        'value' => "mixed",
    ])]
    public function getData() : array
    {
        return [
            'label' => 'array',
            'value' => $this->data,
        ];
    }
}
