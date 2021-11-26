@extends('layouts.app')

@section('content')
{{--<div class="container">--}}
    {{--<div class="row justify-content-center">--}}
        {{--<div class="col-md-8">--}}
            {{--<div class="card">--}}
                {{--<div class="card-header">{{ __('Login') }}</div>--}}

                {{--<div class="card-body">--}}
                    {{--<form method="POST" action="{{ route('login') }}">--}}
                        {{--@csrf--}}

                        {{--<div class="form-group row">--}}
                            {{--<label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Mobile Number') }}</label>--}}

                            {{--<div class="col-md-6">--}}
                                {{--<input id="mobile" type="number" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" required autocomplete="mobile" autofocus>--}}

                                {{--@error('mobile')--}}
                                    {{--<span class="invalid-feedback" role="alert">--}}
                                        {{--<strong>{{ $message }}</strong>--}}
                                    {{--</span>--}}
                                {{--@enderror--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group row">--}}
                            {{--<label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>--}}

                            {{--<div class="col-md-6">--}}
                                {{--<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">--}}

                                {{--@error('password')--}}
                                    {{--<span class="invalid-feedback" role="alert">--}}
                                        {{--<strong>{{ $message }}</strong>--}}
                                    {{--</span>--}}
                                {{--@enderror--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group row">--}}
                            {{--<div class="col-md-6 offset-md-4">--}}
                                {{--<div class="form-check">--}}
                                    {{--<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>--}}

                                    {{--<label class="form-check-label" for="remember">--}}
                                        {{--{{ __('Remember Me') }}--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group row mb-0">--}}
                            {{--<div class="col-md-8 offset-md-4">--}}
                                {{--<button type="submit" class="btn btn-primary">--}}
                                    {{--{{ __('Login') }}--}}
                                {{--</button>--}}

                                {{--@if (Route::has('password.request'))--}}
                                    {{--<a class="btn btn-link" href="{{ route('password.request') }}">--}}
                                        {{--{{ __('Forgot Your Password?') }}--}}
                                    {{--</a>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</form>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card overflow-hidden">
                <div class="bg-login text-center">
                    <div class="bg-login-overlay"></div>
                    <div class="position-relative">
                        <h5 class="text-white font-size-20">
                            ورود به پنل مدیریت
                        </h5>
                        {{--<p class="text-white-50 mb-0">Sign in to continue to Qovex.</p>--}}
                        <a href="/" class="logo logo-admin mt-4">
                            <img src="admin/assets/images/logo-sm-dark.png" alt="" height="30">
                        </a>
                    </div>
                </div>
                <div class="card-body pt-5">
                    <div class="p-2">
                        <form class="form-horizontal" method="POST" action="{{ route('login') }}">

                            @csrf
                            <div class="form-group">
                                <label for="username">شماره موبایل</label>
                                <input type="number" class="form-control @error('mobile') is-invalid @enderror"
                                       name="mobile" value="{{ old('mobile') }}" required autocomplete="mobile" autofocus  >
                                @error('mobile')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">رمز عبور</label>
                                <input  id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            مرا به خاطر بسپار
                                        </label>
                                    </div>
                                </div>
                            </div>



                            <div class="mt-3">
                                <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">ورود</button>
                            </div>

                            {{--<div class="mt-4 text-center">--}}
                                {{--@if (Route::has('password.request'))--}}
                                    {{--<a class="text-muted" href="{{ route('password.request') }}">--}}
                                        {{--<i class="mdi mdi-lock mr-1"></i>--}}
                                        {{--فراموشی رمز--}}
                                    {{--</a>--}}
                                {{--@endif--}}
                            {{--</div>--}}


                        </form>
                    </div>

                </div>
            </div>
            <div class="mt-5 text-center">
                <p>حساب کاربری ندارید؟<a href="{{route('register')}}" class="font-weight-medium text-primary">ثبت نام</a> </p>
                <p>Sagheh.ir © 2020 </p>
            </div>

        </div>
    </div>
</div>
@endsection
