<?php

namespace MangodingID\PixaDump\Payloads;

use JetBrains\PhpStorm\ArrayShape;

class IntegerPayload extends Payload
{

    /**
     * @inheritDoc
     */
    public function getType() : string
    {
        return 'integer';
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
            'label' => 'integer',
            'value' => $this->data,
        ];
    }
}
