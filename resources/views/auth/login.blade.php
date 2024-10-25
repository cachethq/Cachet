@extends('layout.clean')

@section('bodyClass', 'login')

@section('content')
<div class="container">
    <div class="row">
        <div class="form-bg">
            <div class="logo">
                <img src="{{ asset('/img/cachet-logo.svg') }}" class="img-responsive">
            </div>

            <form method="POST" action="{{ cachet_route('auth.login', [], 'post') }}" accept-charset="UTF-8" autocomplete="off" name="{{ str_random(10) }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                @if(Session::has('error'))
                <div class="alert alert-danger">
                    <p>{{ Session::get('error') }}</p>
                </div>
                @endif

                <div class="form-group">
                    <label class="sr-only">{{ trans('forms.login.login') }}</label>
                    <input autocomplete="off" class="form-control login-input" placeholder="{{ trans('forms.login.login') }}" required="required" name="username" type="text" value="{{ Binput::old('username') }}" autofocus>
                </div>
                <div class="form-group">
                    <label class="sr-only">{{ trans('forms.login.password') }}</label>
                    <input autocomplete="off" class="form-control login-input" placeholder="{{ trans('forms.login.password') }}" required="required" name="password" type="password" value="">
                </div>
                <div class="checkbox">
                    <input type="hidden" name="remember_me" value="0">
                    <label>
                        <input name="remember_me" type="checkbox" value="1"> {{ trans('forms.login.remember_me') }}
                    </label>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-2">
                            @if(!config('setting.always_authenticate', false))
                            <a class="btn btn-default btn-lg btn-trans" href="{{ cachet_route('status-page') }}">
                                <span class="text-center">
                                    <i class="ion ion-home"></i>
                                </span>
                            </a>
                            @endif
                        </div>
                        <div class="col-xs-9 col-xs-push-1">
                            <button type="submit" class="btn btn-success btn-lg btn-block btn-trans">{{ trans('dashboard.login.login') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
