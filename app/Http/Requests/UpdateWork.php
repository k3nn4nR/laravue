<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWork extends FormRequest
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
            'work'          => 'required',
            'started_at'    => 'nullable|required_with:due_date|date',
            'due_date'      => 'nullable|required_with:started_at|date',
            'status'        => 'nullable|exists:statuses,id',
        ];
    }
}
