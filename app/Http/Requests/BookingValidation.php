<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingValidation extends FormRequest
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
    public function rules()
    {
        return [
            'name'     => 'required|max:191|alpha',
            'email'    => 'required|email|max:50',
            'address'  => 'required|max:191',
            'car_type' => 'required|numeric|exists:car_types,id',
            
        ];
    }
}
