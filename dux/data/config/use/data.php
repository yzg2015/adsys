<?php
return [
    'dux.cache_driver' => [
        'files' => [
            'type' => 'files',
            'path' => DATA_PATH . 'cache/',
            'group' => 'tmp',
            'deep' => 0,
        ],
        'redis' => [
            'type' => 'redis',
            'host' => '127.0.0.1',
            'port' => 6379,
            'group' => 0,
        ],
    ],
    'dux.storage_driver' => [
        'files' => [
            'type' => 'files',
            'path' => DATA_PATH . 'storage/',
            'group' => 'common',
            'deep' => 0,
        ],
        'redis' => [
            'type' => 'redis',
            'host' => '127.0.0.1',
            'port' => 6379,
            'group' => 0,
        ],
        'mongoDB' => [
            'type' => 'mongoDB',
            'host' => '127.0.0.1',
            'port' => 27017,
            'group' => 0,
        ],
    ],
    'dux.upload_driver' => [
        'local' => [
            'driver' => 'local'
        ],
        'qiniu' => [
            'driver' => 'qiniu',
            'access_key' => '',
            'secret_key' => '',
            'bucket' => '',
            'domain' => '',
            'url' => '',
        ],
        'oss' => [
            'driver' => 'oss',
            'access_id' => '',
            'secret_key' => '',
            'bucket' => '',
            'domain' => '',
            'url' => '',
        ]
    ],
    'dux.image_driver' => [
        'gd' => [
            'driver' => 'gd'
        ],
        'imagick' => [
            'driver' => 'imagick'
        ],
    ],
];