<?php

use Aditya\DetikTest\Models\Event;

require __DIR__."/bootstrap/bootstrap.php";

$event = new Event($dbConnection);

$data = [
    [
        "name" => "Konser JKT48 Anniversary 11th | Semarang",
        "description" => "Konser 11 tahun JKT48"
    ],
    [
        "name" => "Blackpink World Tour Concert [Born Pink] | Jakarta",
        "description" => "Konser Blackpink"
    ]
];

foreach($data as $item) { 
    $event->save($item);
}

echo "Seeder successful";