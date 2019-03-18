<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class ReviewRequest extends FormRequest
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
            'star' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:500'
        ];
    }
    public function messages(){
        return [
            'star.required' => 'The :attribute is required.',
            'star.integer' => 'The :attribute must be integer.',
            'review.string' => 'The :attribute must be string.',
            'review.max' => 'The :attribute has exceed the maximum number of characters.',
        ];
    }
}
