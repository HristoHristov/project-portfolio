@extends('index')
@section('content')
<button onclick="editText()">Edit</button>
{{Form::open(array('id' => 'edit-file','url'=>URL::to('/') . '/project/' . str_replace('/', '|', $path) . '/edit'))}}
{{Form::textarea('textareaValue', $result)}}
{{Form::submit('Save')}}
{{Form::close()}}
<pre>{{$result}}</pre>
@stop