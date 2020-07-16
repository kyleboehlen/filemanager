<?php

namespace App\Rules\Upload;

use Illuminate\Contracts\Validation\Rule;

class Tags implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $tags = explode(',', $value); // boostrap-tagsinput sends tags comma delimited by default
        foreach($tags as $tag)
        {
            if(strlen($tag) > 255) // Verify none of the tags are too long to fit in a varchar(255) column
            {
                $this->failed_tag = $tag;
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Tag '$this->failed_tag' is too long.";
    }
}
