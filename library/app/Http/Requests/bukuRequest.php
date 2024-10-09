<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class bukuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'deskripsi' => 'required|min:5',
            'poster' => 'mimes:png,jpg,jpeg',
            'tahun' => 'required',
            'kategori_id' => 'required'
        ];
    }


    public function messages(): array
    {

        return [
            'title.required' => 'title harus diisi',
            'deskripsi.required' => 'deskripsi harus diisi, minimal 5 karakter',          
            'poster.mimes' => 'poster harus berformat png, jpg, atau jpeg',
            'tahun.required' => 'tahun harus diisi',
            'kategori_id.required' => 'kategori_id harus diisi',
        ];
    }
}
