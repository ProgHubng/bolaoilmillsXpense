<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title class="company"></title>

	  <!-- Bootstrap core CSS     -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('css/login.css') }}" rel="stylesheet" />

    <!--  Paper Dashboard core CSS    -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="{{ asset('css/paper-dashboard.css') }}" rel="stylesheet"/>
	<script src="{{ asset('js/jquery.js') }}"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>

<body class="login-background">
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3" style="margin-top:15%">
            <div class="panel panel-default">
               <div class="header">
						<div class="row">
							<div class="col-lg-12">
							<h3 class="title text-center" style="color:teal;"> <img src="./upload/hostlogo.png"> </br> Expense Manager </h3>
							</div>
						</div>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                           
                            <div class="col-md-9 col-md-offset-2">
							
                                @if ($errors->has('email'))
                                    <span class="help-block text-danger">
                                        <strong><?php echo trans('lang.email_login');?></strong>
                                    </span>
                                @endif
								 <label for="email" class="control-label"><?php echo trans('lang.email');?></label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus="off">

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                           

                            <div class="col-md-9 col-md-offset-2">
								  @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong><?php echo trans('lang.email_login');?></strong>
                                    </span>
                                @endif
								 <label for="password" class="control-label"><?php echo trans('lang.password');?></label>
                                <input id="password" type="password" class="form-control" name="password" required>

                              
                            </div>
                        </div>

                        <!--<div class="form-group">
                            <div class="col-md-6 col-md-offset-2">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>-->

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-2">
                                <button type="submit" class="btn btn-fill btn-primary text-center">
                                    <?php echo trans('lang.login');?> 
                                </button>

                               
                                
                            </div>
                        </div>
                    </form>
                    <center> <a href="./backup"> <button class="btn btn-fill btn-danger text-center">
                                  <i class="fa fa-cloud-download"></i>  Backup Database 
                                </button></a> </center><br>
                    <small><p style="text-align: center;">(c) <?php echo date("Y");?> | WeGoHostU Web & App Services</p></small>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
$.ajax({ 
        headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), sameSite: "None",
            secure: true,
            httpOnly: true
       },    
        type: "GET",
        url: "{{ url('login/getapplication')}}",
        dataType: "json",
        data: "{}",
        success: function (html) {
            var objs = html.data;
            $(".company").html(objs[0].company);
            $("#city").val(objs[0].city);
            $("#currency").val(objs[0].currency);
            $("#phone").val(objs[0].phone);
            $("#address").val(objs[0].address);
            $("#locale").attr(objs[0].languages);
            $("#website").val(objs[0].website);
            $(".logoimg").attr("src",html.logo);

        },

    });
}); 
</script>   
</body>


</html>
