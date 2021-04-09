<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *      title="User Login request",
 *      description="User auth request body data",
 *      type="object",
 *      required={"mobile","login_code"}
 * )
 */
class LoginRequest extends FormRequest
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
     *      title="mobile",
     *      description="",
     *      example="09306029572"
     * )
     *
     * @var string
     */
    private $mobile;

    /**
     * @OA\Property(
     *      title="login_code",
     *      description="",
     *      example="1234"
     * )
     *
     * @var string
     */
    private $login_code;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
