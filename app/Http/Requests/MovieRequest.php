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
            //'year' => 'regex:/.../i'
        ];
    }

    public function messages(){
        return [
          'year.required' => 'The :attribute is required.',
          'year.integer' => 'The :attribute should be integer.',
          'year.digits' => 'The :attribute should be 4 digits.',
          'year.min' => 'The year is not in range.',
          'year.max' => 'The year is not in range.',
        ];
    }
}
