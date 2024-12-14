<?php

namespace App\Http\Requests\API;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
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
            'task_id' => [
                'required',
                'exists:tasks,id',
                Rule::unique('reviews')->where(function ($query) {
                    return $query->where('task_id', request()->task_id);
                }),
            ],
            'star' => 'required|numeric',
            'comment' => 'required|string',
            'image' => 'nullable|array',
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
            'task_id.required' => 'The task ID is required.',
            'task_id.exists' => 'The task does not exist.',
            'task_id.unique' => 'You have already provided a review for this task.',
            'star.required' => 'The rating is required.',
            'star.numeric' => 'The rating must be a number.',
            'comment.required' => 'The comment is required.',
            'comment.string' => 'The comment must be a valid string.',
            'image.nullable' => 'No images are required, but if you provide them, they must be valid.',
            'image.array' => 'The images must be in an array format.',
            'image.*.required' => 'Each image is required if you provide images.',
            'image.*.image' => 'Each file must be a valid image.',
            'image.*.mimes' => 'Each image must be a file of type: jpeg, png, jpg, gif, or svg.',
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
        $fields = ['task_id', 'star', 'comment', 'image'];

        foreach ($fields as $field) {
            if ($field === 'image' && isset($errors['image.*'])) {
                $message = $errors['image.*'][0];
            } else if (isset($errors[$field])) {
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
