<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

// Models
Use App\User;

class HomeTest extends TestCase
{
    /**
     * Verifying users must be authenticated to see the home page.
     *
     * @return void
     * @test
     */
    public function authTest()
    {
        // Unauthorized we should get a login redirect
        $response = $this->get(route('home'));
        $response->assertRedirect('/login');

        // Create a user, and we should now be able to hit home
        $user = factory(User::class)->create();
        $this->actingAs($user)->get(route('home'))->assertOK();
    }
}
