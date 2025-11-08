<?php

namespace App\Http\Requests\Api\Auth;
use App\Http\Requests\GlobalForm;
use Illuminate\Validation\Rule;

class RegisterRequest extends GlobalForm
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
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => ['sometimes', Rule::in(['admin', 'seller', 'customer'])],
        ];
    }

    
}
