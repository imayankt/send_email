
function setCookie(key, value, expiry) {
        var expires = new Date();
        expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
        document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
    }

    function getCookie(key) {
        var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
        return keyValue ? keyValue[2] : null;
    }

    function eraseCookie(key) {
        var keyValue = getCookie(key);
        setCookie(key, keyValue, '-1');
    }
function IsEmail(email) {
    var regex =/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!regex.test(email)) {
        return false;
    }
    else {
        return true;f
    }
}
var token=getCookie('_token');
$("#send_mail").click(function (event) {
    var err=false;
    var email = $('#email').val();
    var subject = $('#subject').val();
    var content = $('#content').val();

    if(subject.trim() ==''){
      $('#subject').next('.error').text('Please enter subject');
      err=true;
    }else{
      $('#subject').next('.error').text('');
    }

    if(email.trim() ==''){
      $('#email').next('.error').text('Please enter email');
      err=true;
    }else if (IsEmail(email.trim()) == false) {
      $('#email').next('.error').text('Invalid email');
      err=true;
    }
    else{
      $('#email').next('.error').text('');
    }
    
    if(content.trim() ==''){
      $('#content').next('.error').text('Please enter content');
      err=true;
    }else{
      $('#content').next('.error').text('');
    }

    if(err==true){
      return false;
    }
    
    $.ajax({
        headers: {
            Authorization: 'Bearer ' + token,
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        type: "POST",
        url: "/api/send-email",
        data: {"email":email,"subject":subject,"content":content},
        success: function (data) {
          if(data.error){
            $.each(data.error,function(key,value){
              $('#'+key).next('error').text(value);
            });    
          }
          
          if(data.status){
            location.reload();        
          }
        }
    });

  });

  function validateToken(){
    $.ajax({
        headers: {
            Authorization: 'Bearer ' + token,
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        type: "get",
        url: "/api/validate-token",
        error:function(data){
          if(data.responseJSON.status == false){
            window.location.href='/';         
          }
        }
    });
  }

  function logout(){
    $.ajax({
        headers: {
            Authorization: 'Bearer ' + token,
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        type: "get",
        url: "/api/logout",
        success: function (data) {
          if(data.status== true){
           window.location.href='/';    
          }
        }
    });
  }
