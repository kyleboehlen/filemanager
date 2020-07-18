<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Artisan;
use Schema;
use Session;

// Controllers
use App\Http\Controllers\UploadController;

// Models
use App\User;

// Requests
use App\Http\Requests\Upload\CreateRequest;

// Rules
use App\Rules\Upload\Tags;

class UploadTest extends TestCase
{
    use WithFaker;

    private $expected_rules;

    protected function setUp(): void
    {
        parent::setUp();

        $mimes = str_replace('.', '', implode(',', config('accept.file_types')));
        $max_file_size = config('accept.max_file_size');

        $this->expected_rules = [
            'title' => 'required|string|max:255',
            'file' => "required|mimes:$mimes|max:$max_file_size",
            'tags' => [new Tags],
        ];
    }

    /**
     * Test the file upload
     *
     * @test
     */
    public function fileUploadTest()
    {
        // Create a test user
        $user = factory(User::class)->create();

        // Create a test file
        $file = UploadedFile::fake()->image('test.jpeg');

        // And submit it to the upload route
        Session::start();
        $response = $this->actingAs($user)->json('POST', route('upload'), [
            '_token' => csrf_token(),
            'title' => $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'file' => $file,
            'tags' => implode(',', $this->faker->words()),
        ]);

        $response->assertRedirect('/home');

        // Assert the file was stored...
        Storage::disk('local')->assertExists('media/' . $file->hashName());
        $user->delete();
    }

    /**
     * Test the upload validation
     *
     * @test
     */
    public function uploadValidationTest()
    {
        // Verify the create method of the upload controller uses the right validation request..
        $this->assertActionUsesFormRequest(UploadController::class, 'create', CreateRequest::class);

        // ...and then verify the upload route is using the right validation request
        $this->assertRouteUsesFormRequest('upload.create', CreateRequest::class);

        // Sweet, everything is tied together properly! Lets verify it has the Auth middleware
        $this->assertActionUsesMiddleware(UploadController::class, 'create', 'auth');

        // And let's verify that the CreateRequest is using the validation rules we expect
        $this->assertValidationRules($this->expected_rules, (new CreateRequest)->rules());
    }
}
