@extends('layouts.app')

@section('content')
{{--<div class="container">--}}
    {{--<div class="row justify-content-center">--}}
        {{--<div class="col-md-8">--}}
            {{--<div class="card">--}}
                {{--<div class="card-header">{{ __('Register') }}</div>--}}

                {{--<div class="card-body">--}}
                    {{--<form method="POST" action="{{ route('register') }}">--}}
                        {{--@csrf--}}

                        {{--<div class="form-group row">--}}
                            {{--<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>--}}

                            {{--<div class="col-md-6">--}}
                                {{--<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>--}}

                                {{--@error('name')--}}
                                    {{--<span class="invalid-feedback" role="alert">--}}
                                        {{--<strong>{{ $message }}</strong>--}}
                                    {{--</span>--}}
                                {{--@enderror--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group row">--}}
                            {{--<label for="family" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>--}}

                            {{--<div class="col-md-6">--}}
                                {{--<input id="family" type="text" class="form-control @error('family') is-invalid @enderror" name="family" value="{{ old('family') }}" required autocomplete="family" autofocus>--}}

                                {{--@error('family')--}}
                                    {{--<span class="invalid-feedback" role="alert">--}}
                                        {{--<strong>{{ $message }}</strong>--}}
                                    {{--</span>--}}
                                {{--@enderror--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group row">--}}
                            {{--<label for="mobile" class="col-md-4 col-form-label text-md-right">{{ __('Mobile Number') }}</label>--}}

                            {{--<div class="col-md-6">--}}
                                {{--<input id="mobile" type="number" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" required autocomplete="mobile">--}}

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
                                {{--<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">--}}

                                {{--@error('password')--}}
                                    {{--<span class="invalid-feedback" role="alert">--}}
                                        {{--<strong>{{ $message }}</strong>--}}
                                    {{--</span>--}}
                                {{--@enderror--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group row">--}}
                            {{--<label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>--}}

                            {{--<div class="col-md-6">--}}
                                {{--<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group row mb-0">--}}
                            {{--<div class="col-md-6 offset-md-4">--}}
                                {{--<button type="submit" class="btn btn-primary">--}}
                                    {{--{{ __('Register') }}--}}
                                {{--</button>--}}
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
                        <h5 class="text-white font-size-20">ثبت نام در بیلچه</h5>
                        {{--<p class="text-white-50 mb-0">Get your free Qovex account now</p>--}}
                        <a href="index.html" class="logo logo-admin mt-4">
                            <img src="admin/assets/images/logo-sm-dark.png" alt="" height="30">
                        </a>
                    </div>
                </div>
                <div class="card-body pt-5">

                    <div class="p-2">
                        <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group">
                                <label for="username">نام</label>
                                <input id="name" type="text" class="form-control text-right @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="family" class="col-md-4 col-form-label text-md-right">نام خانوادگی</label>

                                    <input id="family" type="text" class="form-control text-right @error('family') is-invalid @enderror" name="family" value="{{ old('family') }}" required autocomplete="family" autofocus>

                                    @error('family')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                            </div>

                            <div class="form-group">
                                <label for="mobile" class="col-md-4 col-form-label text-md-right">شماره موبایل</label>


                                    <input id="mobile" type="number" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" required autocomplete="mobile">

                                    @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                            </div>

                            <div class="form-group">
                                <label for="password" class="col-md-4 col-form-label text-md-right">رمز عبور</label>


                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">تکرار رمز عبور</label>


                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>


                            <div class="mt-4">
                                <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">
                                    ثبت نام
                                </button>
                            </div>

                            {{--<div class="mt-4 text-center">--}}
                                {{--<p class="mb-0">By registering you agree to the Skote <a href="#" class="text-primary">Terms of Use</a></p>--}}
                            {{--</div>--}}
                        </form>
                    </div>

                </div>
            </div>
            <div class="mt-5 text-center">
                <p>قبلا ثبت نام کرده اید؟<a href="{{route('login')}}" class="font-weight-medium text-primary">ورود</a> </p>
                <p>Biilche © 2020 </p>
                <p> Crafted with <i class="mdi mdi-heart text-danger"></i> by Ansar Mirzayi</p>
            </div>

        </div>
    </div>
</div>
@endsection
