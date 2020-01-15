<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /** @test */
    function basic_test()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
