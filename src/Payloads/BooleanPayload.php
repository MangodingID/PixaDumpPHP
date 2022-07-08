<?php

namespace MangodingID\PixaDump\Payloads;

use JetBrains\PhpStorm\ArrayShape;

class BooleanPayload extends Payload
{
    /**
     * @return string
     */
    public function getType() : string
    {
        return 'boolean';
    }

    /**
     * @return array
     */
    #[ArrayShape([
        'label' => "string",
        'value' => "mixed",
    ])] public function getData() : array
    {
        return [
            'label' => 'boolean',
            'value' => $this->data,
        ];
    }
}
