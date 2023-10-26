<?php

return [
    'nr' => env('BUILD_NR', '-'),
    'date' => gmdate("d.m.Y H:i:s", env('BUILD_DATE', time()))." Uhr",
];