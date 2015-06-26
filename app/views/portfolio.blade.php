@extends('index')
@section('content')

@if($userId === Session::get('userId'))
{{Form::open(array('url'=>'project/upload-picture/' . $id, 'files'=>true, 'method'=>'post', 'class' => 'upload-file'))}}
{{Form::file('project-pictures[]', array('multiple'=>true))}}
{{Form::button(null, array('type' => null, 'id' => 'upload-pic'))}}
{{Form::close()}}
@endif
@if($showSlider)
    <section id="dg-container" class="dg-container">
        <div class="dg-wrapper">
        
        @foreach($pictures as $key=>$picture)
                <a href="#"><img src="{{URL::to('/')}}/PortfolioImages/{{$picture->picture_name}}" alt="{{URL::to('/')}}/PortfolioImages/{{$picture->picture_name}}"></a>
                
        @endforeach
        </div>
        <nav>
            <span class="dg-prev">&lt;</span>
            <span class="dg-next">&gt;</span>
        </nav>
    </section>


    <script type="text/javascript" src="{{URL::to('/')}}/scripts/jquery.gallery.js"></script>
    <script type="text/javascript">
        $(function() {
            $('#dg-container').gallery();
        });

    </script>
@endif

@stop