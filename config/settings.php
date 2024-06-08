<?php

// App specific config

return [
    'roles' => [
        "Administrator" => 1,
        "Menadzer" => 2,
        "Korisnik" => 3
    ],
    'status' => [
        "Cekanje" => 1,
        "Odobren" => 2,
        "Odbijen" => 3,
    ],
    // Fixed non working days
    'holidays' => [
        '01-01', '01-02', '01-07', '05-01', 
    ]
];