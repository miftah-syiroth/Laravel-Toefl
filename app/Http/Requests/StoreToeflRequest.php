<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreToeflRequest extends FormRequest
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
            'title.unique' => 'Judul TOEFL tidak boleh sama',
            'section_1_imageable.required' => 'Gambar petunjuk section 1 harus diisi',
            'section_1_imageable.image' => 'Gambar petunjuk section 1 harus file gambar',
            'section_2_imageable.required' => 'Gambar petunjuk section 2 harus diisi',
            'section_2_imageable.image' => 'Gambar petunjuk section 2 harus file gambar',
            'section_3_imageable.required' => 'Gambar petunjuk section 3 harus diisi',
            'section_3_imageable.image' => 'Gambar petunjuk section 3 harus file gambar',
            'section_1_track.required' => 'Audio section 1 harus diisi',
            'section_1_track.mimes' => 'File harus berformat mp3',
            'part_a_imageable.required' => 'Petunjuk part A harus diisi',
            'part_a_imageable.image' => 'Petunjuk part A harus file gambar',
            'part_b_imageable.required' => 'Petunjuk part B harus diisi',
            'part_b_imageable.image' => 'Petunjuk part B harus file gambar',
            'part_c_imageable.required' => 'Petunjuk part C harus diisi',
            'part_c_imageable.image' => 'Petunjuk part C harus file gambar',
            'structure_imageable.required' => 'Petunjuk structure harus diisi',
            'structure_imageable.image' => 'Petunjuk structure harus file gambar',
            'written_expression_imageable.required' => 'petunjuk written expression harus diisi',
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
            'title' => 'required|unique:toefls|max:255|string',
            'section_1_imageable' => 'required|image',
            'section_1_track' => 'required|mimes:mp3',
            'part_a_imageable' => 'required|image',
            'part_b_imageable' => 'required|image',
            'part_c_imageable' => 'required|image',
            'section_2_imageable' => 'required|image',
            'structure_imageable' => 'required|image',
            'written_expression_imageable' => 'required|image',
            'section_3_imageable' => 'required|image',
        ];
    }
}
