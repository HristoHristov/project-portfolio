@extends('index')
@section('content')
@if(Session::get('userId') !== null)
{{Form::open(array('url'=>'project', 'id' => 'save-project-name'))}}
    {{Form::text('project-name', null, array('placeholder' => 'Project Name'))}}
@if($resource != 'portfolio')
    {{Form::button(null, array('id' => 'make-directory', 'type' => null))}}
@else
    {{Form::button(null, array('id' => 'make-portfolio', 'type' => null))}}
@endif
{{Form::close()}}
@endif

@foreach($queryResult as $result)
    <div class="project-portfolio">
        @if($resource == 'portfolio')
        <a href="{{($result->project_id)}}/{{$resource}}"><img class="project-name-image" src="{{URL::to('/')}}/websiteImages/folder-flower-orange-icon.png"/>{{($result->project_name)}}</a>
        @elseif($resource == 'edit-repository')
        <a href="{{(URL::to('/') . '/project/' . str_replace('/', '|',public_path() . '/Repository/' . $result->project_name))}}/{{$resource}}"><img class="project-name-image" src="{{URL::to('/')}}/websiteImages/Places-folder-orange-icon.png"/>{{($result->project_name)}}</a>
        @else
        <a href="{{(URL::to('/') . '/project/' . str_replace('/', '|',public_path() . '/Repository/' . $result->project_name))}}/{{$resource}}"><img class="project-name-image" src="{{URL::to('/')}}/websiteImages/Places-folder-orange-icon.png"/>{{($result->project_name)}}</a>
        @endif

        @if($result->project_isPublic)
            <a href="/project/{{$result->project_id}}/private"><img class="project-name-image" src="{{URL::to('/')}}/websiteImages/people-icon.png"/>Make Private</a>
        @else
            <a href="/project/{{$result->project_id}}/public"><img class="project-name-image" src="{{URL::to('/')}}/websiteImages/people-icon.png"/>Make Public</a>
        @endif

    </div>
@endforeach
@stop