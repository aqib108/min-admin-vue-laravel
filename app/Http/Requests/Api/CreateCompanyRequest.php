<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Rules\LogoDimensions;

class CreateCompanyRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422));
    }

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
        // Define common rules for both creation and editing
        $commonRules = [
            'name' => ['required'],
            'email' => ['nullable'],
        ];

        // If 'id' is not provided, it's a creation request
        if (!$this->input('id')) {
            // Add the 'unique' validation for creation
            $commonRules['name'][] = 'unique:companies,name';
            $commonRules['email'][] = 'unique:companies,email';
        }

        // Add file validation rule for image, if present
        if ($this->hasFile('image')) {
            $commonRules['image'] = ['image', new LogoDimensions(100, 100)];
        }

        return $commonRules;
    }
}