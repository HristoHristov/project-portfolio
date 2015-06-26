@extends('index')

@section('content')
    {{Form::open(array('url'=>'user/edit', 'class' => 'authentication'))}}
    <h3>Edit Profile</h3>
    <div>
        {{Form::email('user-email', null, array('placeholder' => 'Email', 'id' => 'email'))}}
    </div>
    <div>
        {{Form::input('password', 'old-user-password', null, array('placeholder' => 'Old Password', 'id' => 'password'))}}
    </div>
    <div>
        {{Form::input('password', 'user-password', null, array('placeholder' => 'New Password', 'id' => 'password'))}}
    </div>
    <div>
        {{Form::input('password', 'user-repeat-password', null, array('placeholder' => 'Repeat Password', 'id' => 'password'))}}
    </div>
    <div>
        {{Form::submit('Login')}}
    </div>
    {{Form::close()}}
@stop