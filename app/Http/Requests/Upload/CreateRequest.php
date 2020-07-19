<?php

namespace App\Http\Requests\Upload;

use Illuminate\Foundation\Http\FormRequest;

// Rules
use App\Rules\Upload\Tags;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // No need to authorize here since the UploadController uses Auth middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $mimes = str_replace('.', '', implode(',', config('accept.file_types')));
        $max_file_size = config('accept.max_file_size'); // In bytes

        return [
            'title' => 'required|string|max:255',
            // 'description' => '', // descrition is a TEXT field in the DB so no validation really needed
            'file' => "required|mimes:$mimes|max:$max_file_size",
            'tags' => [new Tags],
            'attr-name' => 'required_with:attribution_url|string|max:255|nullable',
            'attr-url' => 'required_with:attribution_name|url|max:255|nullable',
        ];
    }
}
