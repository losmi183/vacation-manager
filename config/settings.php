<?php

// App specific config

return [
    'roles' => [
        "Administrator" => 1,
        "Menadzer" => 2,
        "Korisnik" => 3
    ],
    'status' => [
        "1" => "Na čekanju",
        "2" => "Odobren",
        "3" => "Odbijen"
    ],
    // Fixed non working days
    'holidays' => [
        '01-01', '01-02', '01-07', '05-01', 
    ]
];