<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationGroupFormRequest extends FormRequest
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
            'groupName' => 'required',
            'arrivaleDate' => 'required',
            'departureDate' => 'required',
            'namePerson' => 'required',
            'contactPerson' => 'required',
            'addressPerson' => 'required',
            'estimateArrivale' => 'required',
            'methodPayment' => 'required'
        ];

        if ($this->getMethod() == 'POST') {
            $rules += [
                'rooms' => 'required',
            ];
        }
        return $rules;
    }
}
