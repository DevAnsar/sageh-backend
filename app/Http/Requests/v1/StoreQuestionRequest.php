<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *      title="Store Question request",
 *      description="Store Question request body data",
 *      type="object",
 *      required={"content"}
 * )
 */
class StoreQuestionRequest extends FormRequest
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
    public function rules()
    {
        return [
            'content'=>'required|min:3'
        ];
    }
}
