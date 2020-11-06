<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationFormRequest extends FormRequest
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
        $rules = [
            'firstName' => 'required',
            'lastName' => 'required',
            'nationality' => 'required',
            'passport' => 'required',
            'occupation' => 'required',
            'dateBirth' => 'required',
            'homeAddress' => 'required',
            'company' => 'required',
            'purpose' => 'required',
            'arrivaleDate' => 'required',
            'departureDate' => 'required',
            'comingFrom' => 'required',
            'nextDestination' => 'required',
        ];

        return $rules;
    }
}
