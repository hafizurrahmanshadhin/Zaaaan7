<?php

namespace App\Http\Requests\API;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreTransectionRequest extends FormRequest
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
            'amount' => 'required|numeric',
            'transaction_id' => 'required|string',
            'client' => 'required|exists:users,id',
            'helper' => 'required|exists:users,id',
            'task_id' => 'required|exists:tasks,id',
        ];
    }


    public function messages(): array
    {
        return [
            'amount.required' => 'The amount field is mandatory.',
            'amount.numeric' => 'The amount must be a valid number.',
            'transaction_id.required' => 'A transaction ID is required.',
            'transaction_id.string' => 'The transaction ID must be a valid string.',
            'client.required' => 'The client field is mandatory.',
            'client.exists' => 'The selected client does not exist in our records.',
            'helper.required' => 'The helper field is mandatory.',
            'helper.exists' => 'The selected helper does not exist in our records.',
            'task_id.required' => 'The task field is mandatory.',
            'task_id.exists' => 'The selected task does not exist in our records.',
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
        $fields = ['amount', 'transaction_id', 'client', 'helper', 'task_id'];

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
