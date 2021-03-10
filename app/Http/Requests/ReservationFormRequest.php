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
            'mediaReservation' => 'required',
            'methodPayment' => 'required',
            'contactPerson' => 'required',
            'address' => 'required',
            'estimateArrivale' => 'required',
            'deposit' => 'required',
            'numberAccount' => 'required'
        ];
        if ($this->getMethod() == "POST") {
            // $rules += ['rooms' => 'required'];
            $rules += [
                'arrivaleDate' => 'required', 
                'departureDate' => 'required'
            ];
        }

        return $rules;
    }
}
