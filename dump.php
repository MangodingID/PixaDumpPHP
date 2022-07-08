<?php

use MangodingID\PixaDump\PixaDump;

require 'vendor/autoload.php';

$pixadump = new PixaDump('localhost', 1337);

$datas = [
    [1, 2, 3],
];

foreach ($datas as $data) {
    /** @noinspection PhpUnhandledExceptionInspection */
    $pixadump->secure()->dump($data);
}
