<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationFormRequest extends FormRequest
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
            'guestName' => 'required',
            'arrivaleDate' => 'required',
            'departureDate' => 'required',
            'mediaReservation' => 'required',
            'methodPayment' => 'required',
            'contactPerson' => 'required',
            'namePerson' => 'required',
            'address' => 'required',
            'estimateArrivale' => 'required',
            'specialRequest' => 'required',
            // 'rooms' => 'required'
        ];
        if ($this->getMethod() == "POST") {
            $rules += ['rooms' => 'required'];
        }

        return $rules;
    }
}
