<?php

namespace App;

trait ReturnsJsonApi
{
    public function withResponse($request, $response)
    {
        $response->header('Content-Type', 'application/vnd.api+json');
    }
}
