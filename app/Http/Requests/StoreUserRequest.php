<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'employee_number' => ['required', 'digits:4', Rule::unique("users", "employee_number")],
            'password' => ['required', 'string', 'min:6', 'max:32'],
            'role' => ['required', Rule::exists('roles', 'id')]
        ];
    }
}
