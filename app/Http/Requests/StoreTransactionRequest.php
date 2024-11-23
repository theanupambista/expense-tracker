<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
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
            'type' => 'required|in:income,expense',
            'account_id' => ['required', 'exists:accounts,id', function ($attribute, $value, $fail) {
                if (!Auth::user()->accounts()->where('id', $value)->exists()) {
                    $fail('The selected account is not associated with your account.');
                }
            }],
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0',
            'note' => 'nullable|string',
        ];
    }
}
