<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *      title="User Register request",
 *      description="User register request body data",
 *      type="object",
 *      required={"name","family","mobile","password"}
 * )
 */
class RegisterRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'mobile' => 'required|string|size:11|unique:users',
            'password' => 'required|string|min:8,confirmed',//''
        ];
    }
}
