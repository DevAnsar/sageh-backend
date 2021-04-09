<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;



/**
 * @OA\Schema(
 *      title="Store Answer request",
 *      description="Store Answer request body data",
 *      type="object",
 *      required={"content"}
 * )
 */
class StoreAnswerRequest extends FormRequest
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
     * @OA\Property(
     *      title="content",
     *      description="Content of the new Question",
     *      example="A nice Answer"
     * )
     *
     * @var string
     */
    private $content;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'required|min:3'
        ];
    }
}
