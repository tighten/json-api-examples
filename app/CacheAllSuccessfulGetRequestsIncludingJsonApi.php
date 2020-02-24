<?php

namespace App;

use Illuminate\Support\Str;
use Spatie\ResponseCache\CacheProfiles\CacheAllSuccessfulGetRequests;
use Symfony\Component\HttpFoundation\Response;

class CacheAllSuccessfulGetRequestsIncludingJsonApi extends CacheAllSuccessfulGetRequests
{
    public function hasCacheableContentType(Response $response): bool
    {
        $contentType = $response->headers->get('Content-Type', '');

        if (Str::startsWith($contentType, 'text')) {
            return true;
        }

        if (Str::contains($contentType, 'application/json')) {
            return true;
        }

        if (Str::contains($contentType, 'application/vnd.api+json')) {
            return true;
        }

        return false;
    }
}
