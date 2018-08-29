@extends('auth.layouts.master')
@section('title')
    Reset Password
@endsection

@section('content')
    <style>
        .content{
            padding: 20px 20px;
            background-color: rgba(0,0,0,.5);
            color: white;
        }

        .col-form-label{
            padding-right:10px;
        }
        .content-title{
            text-align: center;
            font-family: "Lato Medium";
            color: #a9fd00;
            padding-bottom: 10px;
        }

        .btn-link{
            color: #a9fd00;
        }

    </style>
    <div class="container col-md-offset-4 col-md-6">
        <div class="content">
            <h4 class="content-title">Reset Password</h4>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-8">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary form-control">
                                {{ __('Send Password Reset Link') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
