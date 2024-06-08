<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UsersPaginateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'itemsPerPage'=>'nullable|int',
            'page'=>'nullable|int',
            'search'=>'nullable|string',
        ];
    }

    /**
     * @param Validator $validator
     *
     * @return void
     */
    public function failedValidation(Validator $validator): JsonResponse
    {
        abort(418, $validator->errors());
        return response()->json(['errors' => $validator->errors()], 403);    
    }

    /**
     * Setting default values
     * @return void
     */
    public function prepareForValidation(): void
    {
        if (!array_key_exists('itemsPerPage', $this->all())) {
            $this->merge(['itemsPerPage' => 10]);
        }
        if (!array_key_exists('page', $this->all())) {
            $this->merge(['page' => 1]);
        }
        if (!array_key_exists('search', $this->all())) {
            $this->merge(['search' => '']);
        }
    }
}
