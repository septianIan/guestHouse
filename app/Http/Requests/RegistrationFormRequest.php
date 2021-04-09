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
            "rooms"    => [
                'required',
            ],
            "totalPax"    => [
                'required',
                
            ],
            'firstName' => 'required',
            'lastName' => 'required',
            'nationality' => 'required',
            'passport' => 'required',
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
