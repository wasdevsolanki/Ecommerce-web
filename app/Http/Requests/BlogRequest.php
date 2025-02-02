<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
         'en_blog_title'=>'required',
//        'en_description_one'=>'',
//        'en_description_two'=>'required',
        'small_image'=>'required',
        'big_image'=>'required',
//        'fr_blog_title'=>'required',
//        'fr_description_one'=>'required',
//        'fr_description_two'=>'required',
        ];
    }
}
