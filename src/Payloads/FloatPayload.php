<?php

namespace MangodingID\PixaDump\Payloads;

use JetBrains\PhpStorm\ArrayShape;

class FloatPayload extends Payload
{
    /**
     * @return string
     */
    public function getType() : string
    {
        return 'float';
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
            'label' => 'float',
            'value' => $this->data,
        ];
    }
}
