<?php

namespace MangodingID\PixaDump\Payloads;

use JetBrains\PhpStorm\ArrayShape;

class NullPayload extends Payload
{
    /**
     * @return string
     */
    public function getType() : string
    {
        return 'null';
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
            'label' => 'null',
            'value' => null,
        ];
    }
}
