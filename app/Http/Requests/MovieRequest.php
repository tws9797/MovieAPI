<?php

namespace App\Http\Requests;

use App\Rules\YearRule;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
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
            'year' => ['required', 'integer', new YearRule],
            'director_id' => 'required|exists:directors,id',
            'actors' => 'required|exists:actors,id'
            //'year' => 'regex:/.../i'
        ];
    }

    public function messages(){
        return [
          'name.required' => 'The :attribute is required.',
          'name.string' => 'The :attribute must be string.',
          'name.max' => 'The :attribute character has exceed the range.',
          'year.required' => 'The :attribute is required.',
          'year.integer' => 'The :attribute should be integer.',
          'year.digits' => 'The :attribute should be 4 digits.',
          'year.min' => 'The year is not in range.',
          'year.max' => 'The year is not in range.',
          'director_id.required' => 'The :attribute is required.',
          'director_id.exists' => 'The director does not exists.',
          'actors.required' => 'The :attribute is required.',
          'actors.exists' => 'The actor does not exists.'
        ];
    }
}
