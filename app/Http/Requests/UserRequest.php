<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Can implement authorization logic here later if needed.
        return true;
    }


    // This method will automatically be called before the validation runs
    protected function prepareForValidation()
    {
        $this->merge([
            'first_name' => $this->convertToSnakeCase('firstName'),
            'last_name' => $this->convertToSnakeCase('lastName'),
            'user_name' => $this->convertToSnakeCase('userName'),
            'country_code' => $this->convertToSnakeCase('countryCode'),
            'ip_address' => $this->convertToSnakeCase('ipAddress'),
        ]);
    }

    private function convertToSnakeCase($camelCaseKey)
    {
        return $this->input($camelCaseKey);
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'user_name' => [
                'required',
                'string',
                'unique:users,user_name',
                'regex:/^[\pL]+$/u' // Only letters, no spaces or numbers
            ],
            'country_code' => [
                'required',
                'string',
                'size:2',
                function ($attribute, $value, $fail) {
                    if (!array_key_exists(strtoupper($value), config('countries'))) {
                        $fail('The ' . $attribute . ' must be a valid country code.');
                    }
                },
            ],
            'ip_address' => 'nullable|ipv4',
        ];
    }

    /**
     * Customize the error messages for the form request validation.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'user_name.required' => 'The user name is required.',
            'user_name.unique' => 'This user name has already been taken.',
            'user_name.regex' => 'The user name can only contain letters, no spaces or numbers.',
            'country_code.required' => 'A country code is required.',
            'country_code.size' => 'The country code must be valid 2 characters code.',
        ];
    }
}
