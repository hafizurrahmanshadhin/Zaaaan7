<?php

namespace App\Http\Requests\API;

use App\Rules\API\DateNotInPast;
use App\Rules\API\TimeBasedOnDate;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CreateTaskRequest extends FormRequest
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
            'address_id' => 'required|exists:addresses,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'description' => 'required|string',
            'date' => ['required', 'date', new DateNotInPast],  // Use the custom date rule
            'time' => ['required', 'date_format:H:i', new TimeBasedOnDate($this->input('date'))],  // Use the custom time rule
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
            'address_id.required' => 'The address is required.',
            'address_id.exists' => 'The selected address does not exist.',
    
            'sub_category_id.required' => 'The sub-category is required.',
            'sub_category_id.exists' => 'The selected sub-category does not exist.',
    
            'description.required' => 'Please provide a task description.',
            'description.string' => 'The description must be a valid string.',
    
            'date.required' => 'The task date is required.',
            'date.date' => 'Please provide a valid date for the task.',
    
            'time.required' => 'The task time is required.',
            'time.date_format' => 'The time must be in the format HH:MM (e.g., 14:30).',
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
        $fields = ['address_id', 'sub_category_id', 'description', 'date', 'time'];

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
