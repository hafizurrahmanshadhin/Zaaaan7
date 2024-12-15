<?php

namespace App\Http\Requests\API;

use App\Rules\API\UserRoleIsHelper;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class TaskRequestRequest extends FormRequest
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
            'user_id' => ['required', 'exists:users,id', new UserRoleIsHelper($this->user_id)],
            'task_id' => 'required|exists:tasks,id'
        ];
    }


    /**
     * Get the custom error messages for validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'Please provide a user ID.',
            'user_id.exists' => 'The selected user does not exist.',
            'user_id.user_role' => 'The user must have the role of "helper".',
            'task_id.required' => 'Please select a task.',
            'task_id.exists' => 'The selected task does not exist.',
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
        $fields = ['user_id', 'task_id'];

        foreach ($fields as $field) {
            if (isset($errors[$field])) {
                $message = $errors[$field][0];
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
