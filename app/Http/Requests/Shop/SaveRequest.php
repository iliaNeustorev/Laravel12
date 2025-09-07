<?php

namespace App\Http\Requests\Shop;

use App\Models\Product;
use App\Rules\CheckModelIds;
use Illuminate\Foundation\Http\FormRequest;

class SaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        if (isset($this->products) && is_array($this->products)) {
            $this->merge([
                'checkArray' => collect($this->products)->pluck('id')->toArray(),
            ]);
        }
        
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255', 'min:5'],
            'checkArray' => ['array', new CheckModelIds(Product::class)],
            'products.*.id' => ['required_with:checkArray', 'integer'],
            'products.*.price' => ['integer']
        ];
    }
}
