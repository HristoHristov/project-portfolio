@extends('index')
@section('content')
<h2>{{$results[0]['directoryName']}}
@if($userId === Session::get('userId'))
{{Form::open(array('id'=>'edit-name', 'url'=>"/project/" . str_replace('/', '|', $results[0]['directoryNamePath']) . "/edit-name"))}}
@if(isset($edit))
    {{Form::button(null, array('id' => 'edit', 'onclick' => 'showEditName()'))}}
@endif
{{Form::close()}}
</h2>

<ul id="select-option">
    <li id="make-folder">Make Folder</li>
    <li id="upload-file">Upload File</li>
</ul>

{{Form::open(array('id' => 'show-upload-file-form', 'class' => 'func', 'url'=>'project/' . str_replace('/', '|', $results[0]['directoryNamePath'])  . '/upload-picture/' , 'files'=>true, 'method'=>'post'))}}
{{Form::file('files[]', array('multiple'=>true))}}
{{Form::button(null, array('type' => null, 'id' => 'upload-pic'))}}
{{Form::close()}}

{{Form::open(array('id' => 'show-make-folder-form', 'class' => 'func', 'url' => 'project/' . str_replace('/', '|', $results[0]['directoryNamePath']) . '/make-dir'))}}
{{Form::text('directory-name', null, array('placeholder' => 'Directory Name'))}}
{{Form::button(null, array('id' => 'make-directory', 'type' => null))}}
{{Form::close()}}
@endif
@foreach($results as $result)
    <div>
        @if($result['isDir'])
        <a href="{{URL::to('/') . '/project/' . str_replace('/', '|', $result['path'])}}/repository"><img class="project-name-image" src="{{URL::to('/')}}/websiteImages/Places-folder-orange-icon.png"/>{{$result['name']}}</a>
        @else
        <a href="{{URL::to('/') . '/project/'. str_replace('/', '|', $result['path'])}}/file/open"><img class="project-name-image" src="{{URL::to('/')}}/websiteImages/079750-firey-orange-jelly-icon-business-document.png"/>{{$result['name']}}</a>
        @endif
        @if($result['delete'])
            <a href="{{URL::to('/') . '/project/' . str_replace('/', '|', $result['path'])}}/delete" >
                @if(Session::get('isLogin'))
                <img id="remove" src="{{URL::to('/')}}/websiteImages/delete.png"/>
                @endif
            </a>
        @endif
    </div>
@endforeach
@stop