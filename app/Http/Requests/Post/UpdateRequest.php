<?php

namespace App\Http\Requests\Post;

use Illuminate\Validation\Rules\Unique;

class UpdateRequest extends StoreRequest
{
    /**
     *
     * @return Unique
     */
    protected function uniqueRule(): Unique
    {
        return parent::uniqueRule()->ignore(request()->post);
    }
}
