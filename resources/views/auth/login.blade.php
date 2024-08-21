@extends('layouts.auth')

@section('content')
    <form action="{{ route('login') }}" id="loginform" method="post" autocomplete="off">
        @csrf

        <div class="form-group mb-3">
            <input type="mobile" name="mobile" class="form-control {{ $errors->has('mobile') ? ' is-invalid' : '' }}"
                   placeholder="{{ __('Phone') }}" value="{{ old('mobile') }}" required autofocus>
            @if ($errors->has('mobile'))
                <span class="invalid-feedback">{{ $errors->first('mobile') }}</span>
            @endif
            
        </div>
        <div class="form-group mb-3">
            <input id="password" type="password" placeholder="{{ __('Password') }}"
                   class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
            @if ($errors->has('password'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="row">
            <div class="col-sm-12 mt-4">
                <button type="submit" class="btn btn-primary btn-block">{{ __('Login') }}</button>
            </div>
            <!-- /.col -->
        </div>
    </form>
@endsection
