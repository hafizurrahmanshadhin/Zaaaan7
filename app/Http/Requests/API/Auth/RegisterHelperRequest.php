<?php

namespace App\Http\Requests\API\Auth;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class RegisterHelperRequest extends FormRequest
{
    use ApiResponse;
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
            'first_name' => "required|string",
            'last_name' => "required|string",
            'email' => "required|email|unique:users",
            'password' => "required|confirmed",
            'documents' => 'required|array',
            'documents.*' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'id' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'sub_category_id' => 'required|array|exists:sub_categories,id', // New validation rule
            'sub_category_id.*' => 'exists:sub_categories,id', // Ensure each item in the array exists in sub_categories table
            'description' => 'required|string',
        ];
    }

    /**
     * Define the custom validation error messages.
     *
     * @return array The custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'first_name.string' => 'First name must be a string.',

            'last_name.required' => 'Last name is required.',
            'last_name.string' => 'Last name must be a string.',

            'email.required' => 'Email address is required.',
            'email.email' => 'Email address must be a valid email format.',
            'email.unique' => 'This email is already taken.',

            'password.required' => 'Password is required.',
            'password.confirmed' => 'Passwords do not match.',

            'documents.required' => 'You must upload at least one document.',
            'documents.array' => 'The documents field must be an array.',
            'documents.*.image' => 'Each document must be an image file (JPEG, PNG, JPG, GIF, or SVG).',
            'documents.*.mimes' => 'Each document must be a file of type: jpeg, png, jpg, gif, svg.',

            'id.required' => 'The ID is required.',
            'id.image' => 'The ID must be an image file (JPEG, PNG, JPG, GIF, or SVG).',
            'id.mimes' => 'The ID must be a file of type: jpeg, png, jpg, gif, svg.',
            
            'sub_category_id.required' => 'Sub-category ID is required.',
            'sub_category_id.array' => 'Sub-category ID must be an array.',
            'sub_category_id.exists' => 'The selected sub-category ID is invalid.',
            'sub_category_id.*.exists' => 'Each selected sub-category ID must be valid.',

            'description.required' => 'Description is required.',
            'description.string' => 'Description must be a valid string.',
            'description.min' => 'Description must be at least 10 characters long.',
        ];
    }



    /**
     * Handles failed validation by formatting the validation errors and throwing a ValidationException.
     * 
     * This method is called when validation fails in a form request. It uses the `error` method 
     * from the `ApiResponse` trait to generate a standardized Errorsresponse with the validation 
     * Errorsmessages and a 422 HTTP status code. It then throws a `ValidationException` with the 
     * formatted response.
     *
     * @param Validator $validator The validator instance containing the validation errors.
     *
     * @return void Throws a ValidationException with a formatted Errorsresponse.
     * 
     * @throws ValidationException The exception is thrown to halt further processing and return validation errors.
     */
    protected function failedValidation(Validator $validator): never
    {

        $errors = $validator->errors()->getMessages();

        $message = null;

        // Priority order for fields to check for errors
        $fields = [
            'first_name',
            'last_name',
            'email',
            'password',
            'documents',      
            'id',              
            'sub_category_id',
            'description',
        ];


        foreach ($fields as $field) {
            if (isset($errors[$field])) {
                if ($field === 'documents' && isset($errors['documents.*'])) {
                    $message = $errors['documents.*'][0];
                }
                elseif ($field === 'sub_category_id') {
                    if (isset($errors[$field])) {
                        $message = $errors[$field][0];
                    } elseif (isset($errors['sub_category_id.*'])) {
                        $message = $errors['sub_category_id.*'][0];  
                    }
                }
                else {
                    $message = $errors[$field][0];
                }
                break;
            }
        }

        $response = $this->error(
            422,
            $message,
            $validator->errors(),
        );
        throw new ValidationException($validator, $response);
    }
}
