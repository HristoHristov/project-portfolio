@extends('index')

@section('content')
{{ Form::open(array('url' => 'user', 'class' => 'authentication')) }}
<h3>Register</h3>
    <div>
        {{Form::text('user-name', Input::old('user-name'), array('placeholder'=>'Username', 'id' => 'username'))}}

    </div>
    <div>
        {{Form::email('user-email', Input::old('user-email'), array('placeholder'=>'Email', 'id' => 'email'))}}

    </div>
    <div>
        {{Form::input('password', 'user-password', Input::old('user-password'), array('placeholder'=>'Password', 'id' => 'password'))}}

    </div>
    <div>
        {{Form::input('password', 'user-repeat-password', Input::old('user-repeat-password'), array('placeholder'=>'Repeat Password', 'id' => 'rep-password'))}}

    </div>
    <div>
        {{Form::submit('Register')}}
    </div>
    
{{Form::close()}}
@stop