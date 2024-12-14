<?php

namespace App\Http\Requests\API;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;


class CreateReviewRequest extends FormRequest
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
            'task_id' => 'required|exists:tasks,id',
            'star' => 'required|numeric',
            'comment' => 'required|string',
            'image' => 'required|array',
            'image.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
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
