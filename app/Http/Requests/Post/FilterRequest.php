<?php

namespace App\Http\Requests\Post;

use App\Enums\Posts\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['nullable', 'integer', Rule::in(array_keys(Status::TEXTS))],
            'date' => ['nullable', 'date:Y-m-d'],
            'category' => ['nullable', 'integer', Rule::exists('categories', 'id')]
        ];
    }
}
