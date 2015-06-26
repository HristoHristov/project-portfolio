@extends('index')

@section('content')

{{Form::open(array('url'=>'user/login', 'class' => 'authentication'))}}

<h3>Login</h3>
<div>
    {{Form::text('user-name', null, array('placeholder' => 'Username', 'id' => 'username'))}}
</div>
<div>
    {{Form::input('password', 'user-password', null, array('placeholder' => 'Password', 'id' => 'password'))}}
</div>
<div>
    {{Form::submit('Login')}}
</div>
{{Form::close()}}
@stop