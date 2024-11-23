<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'type' => 'required|in:expense,income',
            'name' => [
                'required',
                Rule::unique('categories')
                    ->where('type', request()->input('type')) // Ensure the uniqueness is scoped to the same `type`
                    ->ignore($this->category->id)
            ],
            'icon' => 'string|max:255'
        ];
    }
}
