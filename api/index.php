<?php

/**
 * Vercel serverless entry point for Laravel.
 *
 * Vercel's Lambda filesystem is read-only except for /tmp, so we make sure the
 * writable directories Laravel expects exist before the framework boots. The
 * matching paths are pointed at /tmp via environment variables in vercel.json
 * (VIEW_COMPILED_PATH, APP_*_CACHE, etc.).
 */
$writableDirs = [
    '/tmp/views',
    '/tmp/cache',
    '/tmp/sessions',
    '/tmp/bootstrap/cache',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/storage/app/public',
];

foreach ($writableDirs as $dir) {
    if (! is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

require __DIR__ . '/../public/index.php';
