@extends('layout.clean')

@section('bodyClass', 'login')

@section('content')
    <div class="container">
        <div class="row">
            <div class="form-bg">
                <div class="logo">
                    <img src="{{ asset('/img/cachet-logo.svg') }}" class="img-responsive">
                </div>

                <br>

                <div class="panel">
                    <div class="panel-body">
                        <div class="text-center">
                            <h3>{{ trans('dashboard.login.two-factor') }}</h3>
                        </div>
                        <br>
                        <form method="POST" action="{{ cachet_route('auth.two-factor', [], 'post') }}" accept-charset="UTF-8">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <fieldset>
                                @if(Session::has('error'))
                                <p class="text-danger">{{ Session::get('error') }}</p>
                                @endif

                                <div class="form-group">
                                    <label class="sr-only">{{ trans('forms.login.2fauth') }}</label>
                                    <input type="text" name="code" class="form-control" placeholder="{{ trans('forms.login.2fauth') }}" required autofocus>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-info btn-lg btn-block btn-trans">{{ trans('dashboard.login.login') }}</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
