@extends('layout.dashboard')

@section('content')
    <div class="header">
        <span class='uppercase'>
            <i class="ion ion-person"></i> {{ trans('dashboard.user.user') }}
        </span>
    </div>
    <div class='content-wrapper'>
        <div class="row">
            <div class="col-sm-12">
                @if($updated = Session::get('updated'))
                <div class='alert alert-{{ $updated ? "success" : "danger" }}'>
                    @if($updated)
                        {{ sprintf("<strong>%s</strong> %s", trans('dashboard.notifications.awesome'), trans('dashboard.user.edit.success')) }}
                    @else
                        {{ sprintf("<strong>%s</strong> %s", trans('dashboard.notifications.whoops'), trans('dashboard.user.edit.failure')) }}
                    @endif
                </div>
                @endif

                <form name='UserForm' class='form-vertical' role='form' action='/dashboard/user' method='POST'>
                    <fieldset>
                        <div class='form-group'>
                            <label>{{ trans('forms.user.username') }}</label>
                            <input type='text' class='form-control' name='username' value='{{ Auth::user()->username }}' required />
                        </div>
                        <div class='form-group'>
                            <label>{{ trans('forms.user.email') }}</label>
                            <input type='email' class='form-control' name='email' value='{{ Auth::user()->email }}' required />
                        </div>
                        <div class='form-group'>
                            <label>{{ trans('forms.user.password') }}</label>
                            <input type='password' class='form-control' name='password' value='' />
                        </div>
                    </fieldset>

                    <button type="submit" class="btn btn-success">{{ trans('forms.save') }}</button>
                </form>
            </div>
        </div>
    </div>
@stop
