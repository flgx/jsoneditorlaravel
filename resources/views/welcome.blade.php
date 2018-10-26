<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Test 2 - JSON Editor</title>

    <link href="{{asset('css/jsoneditor.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('js/jsoneditor.min.js')}}"></script>
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">


</head>
<body>
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
        <div class="top-right links">
            @auth
            <a href="{{ url('/home') }}">Home</a>
            @else
            <a href="{{ route('login') }}">Login</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}">Register</a>
            @endif
            @endauth
        </div>
        @endif

        <div class="container">
            <div class="row">
                <div class="col-xs-5">
                    <h2>
                        Test 2 - JSON Editor
                    </h2>

                    <div id="jsoneditor" style="width: 400px; height: 400px;"></div>
                    <div class="btn btn-primary" id="getjson">Set JSON</div>
                </div>
                <div class="col-xs-2"></div>
                <div class="col-xs-5" id="jsoncontainer" style="display: none;margin-left: 50px;">
                    <h2>
                        Result
                    </h2>
                    <div id="jsontext"></div>
                    <div class="btn btn-primary" id="savejson" style="margin-top: 25px;">Save JSON</div>

                </div>
            </div>

        </div>
    </div>
    <script>
        $(document).ready(function(){


        // create the editor
        var container = document.getElementById("jsoneditor");
        var options = {};
        var editor = new JSONEditor(container, options);
        var token = "{{ csrf_token() }}";
        console.log("TOKE"+token);
        // set json
        var json = {
            "win_occurrence": 30,
            "slot_cash": 100
        };
        editor.set(json);
        var json ='';
        // get json
        $("#setjson").on('click',function(e){

            json = editor.get();
            $("#jsontext").html('');
            $("#jsoncontainer").show();
            $('#jsontext').html(JSON.stringify(json, null, 2));
        });
        $("#savejson").on('click',function(e){
            //shares watcher
                $.ajax({

                url: '{{ url('/savejson') }}',
                type: 'POST',
                data:{_token:token,json:JSON.stringify(json, null, 2)},
                success: function(msg) {
                    console.log(msg['msg']);
                    if(msg['msg']=='success'){
                        alert('JSON Saved!');
                        $("#jsontext").html('');                        
                        $("#jsoncontainer").hide();
                    }
                }
            });
        });
        $("#getjson").on('click',function(e){
            json = editor.get();
            $("#jsontext").html('');
            $("#jsoncontainer").show();
            $('#jsontext').html(JSON.stringify(json, null, 2));
        });
    });
</script>
</body>
</html>
