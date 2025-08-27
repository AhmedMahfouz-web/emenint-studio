<?php

return [
    'formats' => [
        'webp' => [
            'quality' => 85,
            'method' => 6, // WebP compression method (0-6)
        ],
        'jpeg' => [
            'quality' => 90,
            'progressive' => true,
        ],
    ],
    'sizes' => [
        'thumbnail' => ['width' => 300, 'height' => 300],
        'medium' => ['width' => 800, 'height' => 600],
        'large' => ['width' => 1920, 'height' => 1080],
        'original' => null, // Keep original dimensions
    ],
    'max_upload_size' => '50MB',
    'allowed_formats' => ['jpg', 'jpeg', 'png', 'webp'],
];
