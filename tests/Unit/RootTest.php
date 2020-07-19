<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RootTest extends TestCase
{
    /**
     * Verify the root route redirects to home
     *
     * @return void
     * @test
     */
    public function redirectTest()
    {
        // If we're not getting a redirect on root it's probably throwing a 404
        $response = $this->get(route('root'));
        $response->assertRedirect('/home');
    }
}
