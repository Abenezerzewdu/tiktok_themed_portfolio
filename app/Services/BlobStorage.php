<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Minimal client for the Vercel Blob HTTP API.
 *
 * There is no official PHP SDK, so this talks to the same REST endpoint the
 * JavaScript SDK uses. It lets the (read-only, serverless) Vercel deployment
 * persist uploaded files to durable object storage instead of the ephemeral
 * local disk.
 */
class BlobStorage
{
    private const API_URL = 'https://blob.vercel-storage.com';

    // Must match the version the Blob API expects (see @vercel/blob source).
    private const API_VERSION = '12';

    /**
     * Whether Blob storage is configured for this environment.
     */
    public static function isEnabled(): bool
    {
        return (bool) config('services.blob.token');
    }

    /**
     * Upload an uploaded file to Vercel Blob and return its public URL.
     *
     * @param  string  $directory  Logical folder prefix, e.g. "videos".
     */
    public static function upload(UploadedFile $file, string $directory = 'uploads'): string
    {
        $token = config('services.blob.token');

        if (! $token) {
            throw new RuntimeException('BLOB_READ_WRITE_TOKEN is not set.');
        }

        $extension = $file->getClientOriginalExtension() ?: $file->guessExtension() ?: 'bin';
        $pathname = trim($directory, '/').'/'.Str::uuid().'.'.$extension;
        $contentType = $file->getMimeType() ?: 'application/octet-stream';

        $response = Http::withHeaders([
            'authorization' => 'Bearer '.$token,
            'x-api-version' => self::API_VERSION,
            'x-vercel-blob-access' => 'public',
            'x-content-type' => $contentType,
            'x-add-random-suffix' => '1',
        ])
            ->timeout(60)
            ->withBody(
                file_get_contents($file->getRealPath()),
                $contentType
            )
            ->put(self::API_URL.'/'.$pathname);

        if (! $response->successful()) {
            throw new RuntimeException(
                'Vercel Blob upload failed: '.$response->status().' '.$response->body()
            );
        }

        $url = $response->json('url');

        if (! $url) {
            throw new RuntimeException('Vercel Blob upload succeeded but returned no URL.');
        }

        return $url;
    }
}
