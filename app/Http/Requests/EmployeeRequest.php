<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'name' => 'min:2|max:256',
            'date_of_employment' => 'date_format:d.m.y|before:tomorrow',
            'phone' => 'regex:/^([0-9\s\-\+\(\)]*)$/|size:19\'',
            'email' => 'email',
//            'salary' => 'digits_between:10,500',
            'photo' => 'sometimes|file|image|max:5000|mimes:jpeg,png|dimensions:min_width=300,min_height=300',
            'salary' => 'numeric|max:500|regex:/^\d+(\.\d{1,2})?$/'
        ];
    }

    public function messages() {
        return [
            'photo.*' => 'File format jpg, png up to 5 MB, the minimum size of 300x300px'
        ];
    }
}
