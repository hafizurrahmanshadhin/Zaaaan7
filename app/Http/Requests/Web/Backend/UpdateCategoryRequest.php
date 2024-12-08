<?php

namespace App\Http\Requests\Web\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class UpdateCategoryRequest extends FormRequest
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
        $categoryId = $this->route('category')->id;
        return [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'name' => 'required|unique:categories,name,' . $categoryId . ',id',
            'cost' => 'required|numeric',
            'provision' => 'required|numeric',
        ];
    }
}
