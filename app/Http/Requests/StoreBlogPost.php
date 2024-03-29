<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogPost extends FormRequest
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
			'title' => 'required|max:255',
			'content' => 'required:min:10',
		];

        return $rules;
    }

    public function messages() {
    	return [
			'required' => 'Laukelis :attribute privalo buti uzpildytas',
			'title.required' => 'Prasome uzpildyti pavadinima'
		];
	}
}
