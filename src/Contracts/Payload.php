<?php

namespace MangodingID\PixaDump\Contracts;

use JetBrains\PhpStorm\ArrayShape;

interface Payload
{
    /**
     * @return string
     */
    public function getType() : string;

    /**
     * @return array
     */
    #[ArrayShape([
        'label' => "string",
        'value' => "mixed",
    ])]
    public function getData() : array;

    /**
     * @return array
     */
    public function toArray() : array;

    /**
     * @param  int $options
     * @return string
     */
    public function toJson(int $options = 0) : string;
}
