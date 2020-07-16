<?php

namespace Tests\Deploy;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Artisan;
use Schema;

// Controllers
use App\Http\Controllers\UploadController;

// Requests
use App\Http\Requests\Upload\CreateRequest;

// Rules
use App\Rules\Upload\Tags;

class UploadTest extends TestCase
{
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
