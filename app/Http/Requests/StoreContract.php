<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContract extends FormRequest
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
            'person'            => 'required|exists:person_documents,id_number',
            'range'             => 'required',
            'wage'              => 'required_with:payment_switch',
            'payment'           => 'required_with:payment_switch',
            'position'          => 'required_with:position_switch|exists:positions,id',
        ];
    }
}
