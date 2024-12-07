<?php

namespace App\Http\Requests\Web\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'name' => 'required|unique:categories,name',
            'cost' => 'required|numeric',
            'provision' => 'required|numeric',
        ];
    }
}
