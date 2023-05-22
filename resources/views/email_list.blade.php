<!DOCTYPE html>
<html >

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

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
    <div class="row">
      <div class="col-md-6">
        <input type="button" class="btn btn-success" value="Compose" data-toggle="modal" data-target="#myModal"> 
      </div>
      <div class="col-md-6">
        <input type="button" class="btn btn-success" value="Logout" onclick="logout()"> 
      </div>
      
    </div>
    <!-- main app container -->
    <div class="readersack">
      <div class="container">
        <div class="">
          <div class="">
            <table id="example" class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Recipent</th>
                        <th>Subject</th>
                        <th>Body</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id='dataview'>
                    
                </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- credits -->
    
    <!-- Modal -->
    <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Compose</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email">
            <label class='error txt-danger'></label>
          </div>

          <div class="form-group">
            <label for="subject">Subject:</label>
            <input type="subject" class="form-control" id="subject">
            <label class='error txt-danger'></label>
          </div>

          <div class="form-group">
            <label for="content">Content:</label>
            <textarea class="form-control" id="content"></textarea>
            <label class='error txt-danger'></label>
          </div>
          <input type='button' class='btn btn-success' id='send_mail' value='Submit'>
        </div>
              
      </div>
    </div>
  </div>
  </div>
  <script src="{{url('js/custom_script.js')}}"></script>
  <script>
    var token=getCookie('_token');
    var listData='';
    validateToken();
    $.ajax({
        type: "GET",
        url: "/api/email-list",
        headers: {
            Authorization: 'Bearer ' + token,
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        success: function (response) {
          
          if(response){
              $.each(response.data,function(key,value){
                 
                  listData+='<tr>'+
                      '<td>'+value.receiver_email+'</td>'+
                      '<td>'+value.subject+'</td>'+
                      '<td>'+value.content+'</td>'+
                      '<td>'+value.status+'</td>'+
                      '</tr>';
              })

            $('#dataview').html(listData);

          }
        }
    });

     
  </script>
</body>

</html>