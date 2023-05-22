<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title> login</title>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
  <script src="{{url('js/custom_script.js')}}"></script>
  <link href="//netdna.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    .error {
      color: red
    }
  </style>
</head>

<body class="antialiased">
  <div class="container">
    <!-- main app container -->
    <div class="readersack">
      <div class="container">
        <div class="row">
          <div class="col-md-6 offset-md-3">
            <h3>Login</h3>

            <div id="errors-list"></div>
            <form method="post" id="handleAjax" action="{{url('do-login')}}" name="postform">
              <div class="form-group">
                <label class='response-error txt-danger'></label>
              </div>
              <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" id="email" value="{{old('email')}}" class="form-control" />
                <label class='error txt-danger'></label>
              </div>
              <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="password" class="form-control" />
                <label class='error txt-danger'></label>
              </div>
              <div class="form-group">
              <div class="form-group">
                <button type="button" class="btn btn-primary" id='formSubmit'>LOGIN</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- credits -->
    <div class="text-center">
      <p>
        <a href="{{url('register')}}" target="_top">Register </a>
      </p>
    </div>
  </div>

 
</body>
<script>
    
  $("#formSubmit").click(function (event) {
   var err=false;
  
  if($('#email').val().trim() ==''){
    $('#email').next('.error').text('Please enter email');
    err=true;
  }
  else{
    $('#email').next('.error').text('');
  }

  if($('#password').val().trim() ==''){
    $('#password').next('.error').text('Please enter password');
    err=true;
  }else{
    $('#password').next('.error').text('');
  }

  if(err==true){
    return false;
  }

  $.ajax({
      type: "POST",
      dataType: "json",
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      url: "/api/login",
      data: {'email':$('#email').val(),'password':$('#password').val()},
      success: function (response) {
        if(response.data.token){

          // window.location.href='user-detail/'+data.token; 
          setCookie('_token', response.data.token);
          window.location.href='emails';
        }
      
      },
      error:function(data){
        if(data.responseJSON.error){
          $.each(data.responseJSON.error,function(key,value){
            $('#'+key).next('.error').text(value[0]);
          });    
        }
        $('.response-error').html(data.responseJSON.message);       
      }
  });

  });
     
  </script>
</html>
