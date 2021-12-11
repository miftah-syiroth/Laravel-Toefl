<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateToeflRequest extends FormRequest
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
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Judul TOEFL harus diisi',
            'section_1_imageable.image' => 'Gambar petunjuk section 1 harus file gambar',
            'section_2_imageable.image' => 'Gambar petunjuk section 2 harus file gambar',
            'section_3_imageable.image' => 'Gambar petunjuk section 3 harus file gambar',
            'section_1_track.mimes' => 'File harus berformat mp3',
            'part_a_imageable.image' => 'Petunjuk part A harus file gambar',
            'part_b_imageable.image' => 'Petunjuk part B harus file gambar',
            'part_c_imageable.image' => 'Petunjuk part C harus file gambar',
            'structure_imageable.image' => 'Petunjuk structure harus file gambar',
            'written_expression_imageable.image' => 'petunjuk written expression harus file gambar',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255|string',
            'section_1_imageable' => 'image',
            'section_1_track' => 'mimes:mp3',
            'part_a_imageable' => 'image',
            'part_b_imageable' => 'image',
            'part_c_imageable' => 'image',
            'section_2_imageable' => 'image',
            'structure_imageable' => 'image',
            'written_expression_imageable' => 'image',
            'section_3_imageable' => 'image',
        ];
    }
}
