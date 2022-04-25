@extends('login.layouts.app')
@section('title') Login @endsection
@section('content')
    <div class="login-logo">
        <a><b>User</b> Login</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            @include('includes.messages')
            <p class="login-box-msg">Login to start your session</p>
            {!! Form::open(['url'=>'login','method'=>'post']) !!}
            <div class="form-group">
                <div class="input-group mb-3">
                    {!! Form::email('email','',['class'=>$errors->has('email')?'form-control is-invalid':'form-control','placeholder'=>'Email Address']) !!}
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group mb-3">
                    {!! Form::password('password',['class'=>$errors->has('password')?'form-control is-invalid':'form-control','placeholder'=>'Password']) !!}
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-right">
                    <a href="{{ url('/register') }}">Register</a>
                </div>

                <div class="col-12 mt-2">
                    {!! Form::submit('Login',['class'=>'form-control btn btn-primary']) !!}
                </div>
                <!-- /.col -->
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.login-card-body -->
    </div>
@endsection
