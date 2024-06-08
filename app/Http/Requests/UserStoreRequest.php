<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UserStoreRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password'=>'required|min:4',
            // 'role_id'=>'required|integer|in:2,3', // Can create only korisnik or Menadzer
            'team_id'=>'nullable|integer',
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
    // public function prepareForValidation(): void
    // {
    //     if (!array_key_exists('x', $this->all())) {
    //         $this->merge(['x' => 'default']);
    //     }     
    // }
}
