<?php

return [
    'file_types' => [
        '.jpg',
        '.jpeg',
        '.mp4',
    ],
    'max_file_size' => env('UPLOAD_MAX_FILE_SIZE', 2000), // In bytes
];