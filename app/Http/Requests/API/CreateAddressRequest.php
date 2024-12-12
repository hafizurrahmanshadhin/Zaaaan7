<?php

namespace App\Http\Requests\API;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CreateAddressRequest extends FormRequest
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
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'name' => 'required|string',
            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'zip' => 'required|string',
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
            'latitude.required' => 'Latitude is required.',
            'latitude.numeric' => 'Latitude must be a numeric value.',
            'longitude.required' => 'Longitude is required.',
            'longitude.numeric' => 'Longitude must be a numeric value.',
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a valid string.',
            'country.required' => 'Country is required.',
            'country.string' => 'Country must be a valid string.',
            'state.required' => 'State is required.',
            'state.string' => 'State must be a valid string.',
            'city.required' => 'City is required.',
            'city.string' => 'City must be a valid string.',
            'zip.required' => 'Zip code is required.',
            'zip.string' => 'Zip code must be a valid string.',
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
        $fields = ['latitude', 'longitude', 'name', 'country', 'state', 'city', 'zip'];

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
