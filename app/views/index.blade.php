<!DOCTYPE html>
<html>
    <head>
        <title>Portfolio</title>
        <link rel="stylesheet" href="{{URL::to('/')}}/css/style.css">
        <link rel="stylesheet" type="text/css" href="{{URL::to('/')}}/css/slider.css" />
        <script type="text/javascript" src="{{URL::to('/')}}/scripts/modernizr.custom.53451.js"></script>
    </head>
    <body>
        <div id="outer"></div>
        <header>
            <ul>
                @if(!Session::get('isLogin'))
                <li><a href="/user/login">Login</a></li>
                <li><a href="/user/create">Register</a></li>
                @else
                <li><a href="/project">Home</a></li>
                    <li><a href="/project/repository">Repository</a></li>
                    <li><a href="/project/portfolio">Portfolio</a></li>
                    <li><a href="/user/edit">Edit Profile</a></li>
                    <li><a href="/project/repository/edit-repository">Edit Project</a></li>
                    <li><a href="/user/logout">Logout</a></li>
                @endif
            </ul>
        </header>
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        Gosop
        <div id="wrapper">
            @if(count($errors->all()) > 0)
            <div id="errors">
                @foreach($errors->all() as $error)
                    {{$error}}
                @endforeach
            </div>
            @endif
            @yield('content')</div>
    <script>
        var $li = $('header ul li');
        if($li.length > 2) {
            $li.css('margin-left', (45/$li.length) + '%');
        }
        var documentHeight = $(document).height();
        $('body').css('background-size', '100% ' + documentHeight + 'px');
        var isShow = false;
        var isShowUploadFile = false;
        var isShowMakeFolder = false;
        var showMakeFolder =  $('#show-make-folder-form');
        var showUploadFile = $('#show-upload-file-form');
        $('#left-button').click(previousSlide);
        $('#right-button').click(nextSlide);
        $('#make-folder').click(makeFolder);
        $('#upload-file').click(uploadFile);
        function previousSlide() {
                $('#portfolio > ul li').first().before($('#portfolio > ul li').last());
                $('#portfolio > ul').css('margin-left', '-700px')
                $('#portfolio > ul').animate({'margin-left': '0px'}, 1500);
        }
        function makeFolder() {
            if(isShowMakeFolder) {
                showMakeFolder.hide();
                isShowMakeFolder = false;
            } else {
                showMakeFolder.show();
                isShowMakeFolder = true;
            }
        }
        function uploadFile() {
            if(isShowUploadFile) {
                showUploadFile.hide();
                isShowUploadFile = false;
            } else {
                showUploadFile.show();
                isShowUploadFile = true;
            }
        }
        function nextSlide(){
            $('#portfolio > ul').animate(
                    {'margin-left': '-700px'},
                    1500,
                    null,
                    function(){
                        $('#portfolio > ul li').last().after($('#portfolio > ul li').first())
                        $('#portfolio > ul').css({'margin-left': '0px'})
                    });
        }
        function showEditName() {
            var $inputText = $('<input/>').attr({'name': 'name', 'type': 'text'});
            var $inputSubmit = $('<input/>').attr({'value': 'Save', 'type': 'submit'});
            $('#edit-name').append($inputText);
            $('#edit-name').append($inputSubmit);
            console.log($inputText);
        }
        function editText() {
            if(isShow === true) {
                $('form').hide();
                isShow = false;
            } else {
                $('form').show();
                isShow = true;
            }
        }
    </script>
    </body>
</html>
