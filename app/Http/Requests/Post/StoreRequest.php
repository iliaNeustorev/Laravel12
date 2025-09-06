<?php

namespace App\Http\Requests\Post;

use App\Models\Category;
use App\Rules\SoftExists;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class StoreRequest extends FormRequest
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
            'url' => [ 'required', 'min:5', 'max:255', $this->uniqueRule()],
            'title' => ['required', 'min:5', 'max:255'],
            'content' => ['required'],
            'category_id' => ['nullable', new SoftExists(Category::class)]
        ];
    }

    /**
     *
     * @return Unique
     */
    protected function uniqueRule(): Unique
    {
        return Rule::unique('posts');
    }

    /**
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'title' => 'Заголовок',
            'content' => 'Текст'
        ];
    }
}
