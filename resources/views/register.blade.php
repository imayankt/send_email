<!DOCTYPE html>
<html >

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>login and registration</title>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
  <link href="//netdna.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" />
  <script type="text/javascript" src="index.js"></script>
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
            <h3>Registration</h3>

            
            <form method="post" id="handleRegisterAjax"  name="postform">
              @csrf
              <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" id='name' value="" class="form-control" />
                <label class='error txt-danger'></label>
              </div>
              <div class="form-group">
                <label>Email</label>
                <input type="email" name="email"  id='email' class="form-control" />
                <label class='error txt-danger'></label>
              </div>
              <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="password" class="form-control" />
                <label class='error txt-danger'></label>
              </div>
              
              <div class="form-group">
                  <label>Password Confirmation</label>
                  <input type="password" class="form-control" id="password_confirmation"
                        name="password_confirmation">
              </div>

            <div class="form-group">
                <button type="button" id='formSubmit' class="btn btn-primary">REGISTER</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- credits -->
    <div class="text-center">
      <p>
        <a href="{{url('login')}}" target="_top">login </a>
      </p>
      
    </div>
  </div>
  <script src="{{url('js/custom_script.js')}}"></script>
  <script>
    
  $("#formSubmit").click(function(event) {
   var err=false;
   var email=$('#email').val();
  if($('#name').val().trim() ==''){
    $('#name').next('.error').text('Please enter name');
    err=true;
  }else{
    $('#name').next('.error').text('');
  }

  if(email.trim() ==''){
    $('#email').next('.error').text('Please enter email');
    err=true;
  }else if (IsEmail(email) == false) {
    $('#email').next('.error').text('Invalid email');
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
  var data = new FormData($('#handleRegisterAjax')[0]);
    

  $.ajax({
      type: "POST",
      enctype: 'multipart/form-data',
      url: "/api/register",
      data: data,
      processData: false,
      contentType: false,
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
</body>

</html>