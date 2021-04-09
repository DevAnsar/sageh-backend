<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\LoginRequest;
use App\Http\Requests\v1\RegisterRequest;
use App\Models\User;
use App\Notifications\VerificationCode;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private $verification_code_len = 4;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'send_verification_code', 'check_mobile', 'mobile_register','pre_register']]);
    }

    /**
     * Get a JWT via given credentials.
     * @param  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function check_mobile(Request $request)
    {
        try {
            if ($request->has('mobile') && trim($request->input('mobile')) != null) {
                if (strlen($request->input('mobile')) == 11) {
                    $user = User::where('mobile', $request->input('mobile'))->first();
                    if ($user) {
                        return $this->check_mobile_response(true, '', true);
                    } else {
                        return $this->check_mobile_response(true, '', false);
                    }
                } else {
                    return $this->check_mobile_response(false, 'شماره موبایل باید 11 عددی باشد', false);

                }

            } else {
                return $this->check_mobile_response(false, 'شماره موبایل را وارد کنید', false);

            }
        } catch (\Exception $exception) {
//            return $exception->getMessage();
            return $this->check_mobile_response(false, 'مشکلی در اجرای درخواست بوجود آمد. دوباره تلاش کنید', false);


        }
    }

    public function check_mobile_response($status, $message, $has_user, $request_status = 200)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'has_user' => $has_user,
        ], $request_status);

    }

    /**
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send_verification_code(Request $request)
    {
        try {
            if (!isset($request->mobile)) {
                return response()->json(['status' => false, 'message' => 'شماره موبایل الزامی است'], 200);
            }
            if (!isMobile($request->mobile)) {
                return response()->json(['status' => false, 'message' => 'شماره موبایل صحیح نیست'], 200);
            }

            $user = User::whereMobile($request->mobile)->first();

            if ($user) {

                $loginCode = generateRandomNumber($this->verification_code_len);
//        $password = Hash::make($request->mobile);

                $user->update(['login_code' => $loginCode]);
                $user->notify(new VerificationCode($user->mobile, $loginCode));
                return response()->json(['status' => true, 'login_code' => $loginCode, 'message' => 'رمز عبور یکبار مصرف به شماره موبایل ارسال شد']);

            } else {
                return response()->json(['status' => false, 'message' => 'کاربر با شماره موبایل وارد شده یافت نشد'], 200);
//            $name = 'u';
//            $family = generateRandomNumber(6);
//            $user = User::create([
//                'name' => $name,
//                'family' => $family,
//                'mobile' => $request->mobile,
//                'password' => $password,
//                'login_code' => $loginCode
//            ]);
            }
        } catch (\Exception $exception) {
            $this->exceptionResponse($exception, 'مشکلی در اجرای درخواست بوجود آمد. دوباره تلاش کنید');
        }


    }

    /**
     * Get a JWT via given credentials.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        if (!$request->has('mobile')){
            return $this->customResponse(false, 'شماره موبایل وارد نشده است');
        }


        if (!isMobile($request->input('mobile'))){
            return $this->customResponse(false, 'شماره موبایل وارد شده صحیح نمیباشد');
        }
        $mobile=replace_number_en(trim($request->input('mobile')));
        $_user=User::whereMobile($mobile)->first();

        if (!$_user){
            return $this->customResponse(false, 'شما تا حالا ثبت نام نکرده اید');

        }

        if ($request->has('password')) {
            $credentials = request(['mobile', 'password']);
            if (!$token = auth('api')->attempt($credentials)) {
                return $this->customResponse(false, 'رمز وارد شده اشتباه است');
            }
            $user = auth('api')->user();
            return $this->respondWithToken($token, getAccountStatus($user));
        } else {

            if ($request->has('login_code')) {

                if (strlen(trim($request->input('login_code'))) == $this->verification_code_len) {
                    $user = User::whereMobileAndLogin_code($request->mobile, $request->login_code)->first();
                    if ($user) {
                        $token = auth('api')->login($user);
                        $user->update(['login_code' => null]);
                        return $this->respondWithToken($token,getAccountStatus($user));
                    } else {
                        return $this->customResponse(false, 'رمز وارد شده اشتباه است');
                    }
                } else {
                    return $this->customResponse(false, "رمز یکبار مصرف باید " . $this->verification_code_len . " عددی باشد");

                }
            } else {
                return $this->customResponse(false, 'رمز عبور یا کد یکبار مصرف الزامی است');
            }

        }


    }


    /*
      *
      * Get a JWT via given credentials.
      *
      * @param Request $request
      * @return \Illuminate\Http\JsonResponse
      * @throws \Illuminate\Validation\ValidationException
      */

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @param array $extra
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $extra = [])
    {


        $response = [
            'status' => true,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ];


        $response = array_merge($response, $extra);


        return response()->json($response);
    }

    public function pre_register(Request $request)
    {
        try {

            if (!$request->has('mobile')){
                return $this->customResponse(false, 'شماره موبایل وارد نشده است');
            }


            if (!isMobile($request->input('mobile'))){
                return $this->customResponse(false, 'شماره موبایل وارد شده صحیح نمیباشد');
            }

            $next_minute = 5;
            $mobile = replace_number_en(trim($request->input('mobile', '')));
             $disposable_code = generateRandomNumber(5);

            $user = User::whereMobile($mobile)->first();
            if (!$user) {
                $disposable_field = DB::table('disposable_codes')->where('mobile', '=', $mobile)->first();


                if ($disposable_field) {

                    DB::table('disposable_codes')->where('mobile', '=', $mobile)->update([
                        'code' => $disposable_code,
                        'expiration_date' => Carbon::now()->addMinutes($next_minute),
                        'used' => false,
                    ]);

                } else {
                    $now=Carbon::now();
                    DB::table('disposable_codes')->insert([
                        'mobile' => $mobile,
                        'code' => $disposable_code,
                        'expiration_date' => $now->addMinutes($next_minute),
                        'used' => false,
                        'created_at'=>$now,
                        'updated_at'=>$now
                    ]);
                }

                new VerificationCode($mobile, $disposable_code);

                return $this->customResponse(true, 'کد یکبار مصرف برای شما ارسال شد', ['register_code' => $disposable_code]);

            } else {
                return $this->customResponse(false, 'کاربر با شماره موبایل وارد شده از قبل وجود دارد');

            }
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception, 'مشکلی پیش آمد');
        }
    }

    /**
     * @param  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function mobile_register(Request $request)
    {
        try {
            if ($request->has('mobile') && trim($request->input('mobile')) != null) {
                if ($request->has('register_code') && trim($request->input('register_code')) != null) {


                    if (isMobile($request->input('mobile'))) {

                        $mobile = trim($request->input('mobile'));
                        $disposable_field = DB::table('disposable_codes')->where('mobile', '=', $mobile)->first();
                        if ($disposable_field) {
                            if ($disposable_field->expiration_date != null && $disposable_field->expiration_date > Carbon::now()) {
                                if (!$disposable_field->used) {
                                    if ($disposable_field->code == $request->input('register_code')) {

                                        $user = User::where('mobile', $request->input('mobile'))->first();

                                        if ($user) {
                                            $user->update([
                                                'mobile' => $mobile,
                                                'mobile_status' => true,
                                                'login_code' => null
                                            ]);
                                        } else {

                                            $user = User::create([
                                                'mobile' => $mobile,
                                                'password' => null,
                                                'status' => 1,
                                                'business' => false,
                                                'mobile_status' => true
                                            ]);

//                                            event(new Registered($this->confirm_register($user, $request->all())));
                                        }

                                        DB::table('disposable_codes')->where('mobile', '=', $mobile)->update([
                                            'used' => true,
                                        ]);
                                        $token = auth('api')->login($user);
                                        return $this->respondWithToken($token, getAccountStatus($user));

                                    } else {
                                        return $this->customResponse(false, 'کد وارد شده صحیح نیست');

                                    }
                                } else {
                                    return $this->customResponse(false, 'رمز یکبار مصرف قبلا استفاده شده است');

                                }
                            } else {
                                return $this->customResponse(false, 'کد منقضی شده است');
                            }

                        } else {
                            return $this->customResponse(false, 'کد یکبار مصرف فعلا برای شما ایجاد نشده است');
                        }
                    } else {
                        return $this->customResponse(false, 'شماره موبایل صحیح نیست');

                    }
                } else {
                    return $this->customResponse(false, 'کد یکبار مصرف را وارد کنید');
                }

            } else {
                return $this->customResponse(false, 'شماره موبایل ارسال نشده است');

            }
        } catch (\Exception $exception) {
//            return $exception->getMessage();
            return $this->customResponse(false, 'مشکلی در اجرای درخواست بوجود آمد. دوباره تلاش کنید');


        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param User $user
     * @param  array $data
     * @return User
     */
    protected function confirm_register(User $user, array $data)
    {
        $user->update([
            'name' => $data['name'],
            'family' => $data['family'],
//            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        return $user;
    }


    /*
         * Get a validator for an incoming registration request.
         *
         * @param  array $data
         * @return \Illuminate\Contracts\Validation\Validator
         */

    public function register_profile_data(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'family' => 'required|string|max:255',
                'account_image' => 'nullable|image',
                'brand' => 'nullable|string|max:255',
            ]);
            $user = auth('api')->user();

            $account_image = '';
            if ($request->hasFile('account_image')) {
                $account_image = '/hasFile.png';
            }
            $user->update([
                'name' => $request->name,
                'family' => $request->family,
                'account_image' => $account_image,
                'brand' => $request->brand,
            ]);

            return $this->customResponse(true, 'اطلاعات با موفقیت ثبت شد');
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception, 'مشکلی پیش آمد');
        }
    }



    public function password_register(Request $request)
    {
        try {
            $this->validate($request, [
                'password' => ['required', 'string', 'min:8','confirmed'],
            ]);
            $user = auth('api')->user();

            $password=Hash::make($request->input('password'));
            $user->update([
                'password' => $password,
            ]);

            return $this->customResponse(true, 'اطلاعات با موفقیت ثبت شد');
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception, 'مشکلی پیش آمد');
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return $this->customResponse(true, 'با موفیت خارج شدید');

    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'family' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'size:11', 'unique:users'],
//            'password' => ['required', 'string', 'min:8'],//'confirmed'

        ]);
    }



    /**
     * Get a JWT via given credentials.
     * @param  $request
     * @return \Illuminate\Http\JsonResponse
     */
//    public function verification_mobile(Request $request)
//    {
//        try {
//            if ($request->has('mobile') && trim($request->input('mobile')) != null) {
//                if ($request->has('login_code') && trim($request->input('login_code')) != null) {
//
//
//                    if (strlen($request->input('mobile')) == 11) {
//                        $user = User::where('mobile', $request->input('mobile'))->first();
//                        if ($user) {
//                            if ($user->login_code == $request->input('login_code')) {
//                                $user->update([
//                                    'mobile_status' => true,
//                                    'login_code' => null
//                                ]);
//                                return $this->customResponse(true, 'شماره موبایل تایید شد');
//                            } else {
//                                return $this->customResponse(false, 'کد وارد شده صحیح نیست');
//
//                            }
//
//                        } else {
//                            return $this->customResponse(false, 'کاربری با این شماره موبایل وجود ندارد');
//                        }
//                    } else {
//                        return $this->customResponse(false, 'شماره موبایل باید 11 عددی باشد');
//
//                    }
//                } else {
//                    return $this->customResponse(false, 'کد یکبار مصرف را وارد کنید');
//                }
//
//            } else {
//                return $this->customResponse(false, 'شماره موبایل ارسال نشده است');
//
//            }
//        } catch (\Exception $exception) {
////            return $exception->getMessage();
//            return $this->customResponse(false, 'مشکلی در اجرای درخواست بوجود آمد. دوباره تلاش کنید');
//
//
//        }
//    }




    /*
      *
      *
      * @param Request $request
      * @return \Illuminate\Http\JsonResponse
      * @throws \Illuminate\Validation\ValidationException
      */

//    public function register(RegisterRequest $request)
//    {
//        try {
//            $password = Hash::make($request->password);
//            $user = User::create([
//                'mobile' => $request->mobile,
//                'password' => $password,
//                'status' => 1,
//                'business' => false,
//                'mobile_status' => false
//            ]);
//
//            event(new Registered($this->confirm_register($user, $request->all())));
//
//            $token = auth('api')->login($user);
//            return $this->respondWithToken($token);
////            return $this->customResponse(true,'شماره موبایل در سیستم ثبت شد');
//        } catch (\Exception $exception) {
//            return $this->exceptionResponse($exception, 'مشکلی پیش آمد');
//        }
//    }
}
