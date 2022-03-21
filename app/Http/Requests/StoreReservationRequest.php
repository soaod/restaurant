<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'table' => ['required', 'integer', Rule::exists('tables', 'id')],
            'starting_time' => ['required', 'date_format:H:i:s'],
            'ending_time' => ['required', 'date_format:H:i:s'],
        ];
    }
}
