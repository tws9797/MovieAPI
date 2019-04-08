<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActorRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'movies' => 'required|exists:movies,id'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The :attribute is required.',
            'name.string' => 'The :attribute must be a string',
            'name.max' => 'The :attribute must consist below 100 characters.',
            'movies.required' => 'The :attribute is required.',
            'movies.exists' => 'The movie does not exists.'
        ];
    }
}
