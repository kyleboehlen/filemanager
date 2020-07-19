<?php

return [
    'file_types' => [
        '.jpg',
        '.jpeg',
        '.mp4',
    ],
    'max_file_size' => env('UPLOAD_MAX_FILE_SIZE', 2000000), // In bytes
    'max_user_storage' => env('MAX_USER_STORAGE', 10000000), // In bytes
    // I'd like to quickly note here that I would write that as 10_000_000 if I could make my php requirement 7.4
    // That being said, the test says GoReact uses PHP 7.2 so... I won't.
    // I know it's small thing, but hey makes it a lot easy to read
];