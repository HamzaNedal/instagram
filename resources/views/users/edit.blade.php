  @extends('layouts.app')

  @section('content')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('js/toastr/build/toastr.min.css') }}">
@endpush


  @if ($errors->any())
      @foreach ($errors->all() as $error)
        {{ $error }}
      @endforeach
    @endif

    @if (Session::has('success'))
        {{ session('success') }}
    @endif


<div class="row">



  <div class="col-3">
    <div class="container">
      <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Edit Profile</a>
        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Change Password</a>
        <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Privacy</a>

      </div>
    </div>
  </div>

      <div id='error'>

       </div>

  <div class="col-9">
    <div class="tab-content" id="v-pills-tabContent">
      <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">

        <div class="row">
          <div class="col-md-9">
            <div class="card">




              <header class="card-header">

                <h4 class="card-title mt-2">Edit Profile</h4>
              </header>
              <article class="card-body">
                <form action="{{ url('users/'.$user->id) }}" method="Post" >@csrf @method('put')

                  <div class="form-group">
                    <label>Full name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="" value="{{ $user->name }}">
                  </div> <!-- form-group end.// -->

                    <div class="form-group">
                      <label>Username</label>
                      <input type="text" class="form-control" name="username" id="username" placeholder=" " value="{{ $user->username }}">
                      <small class="form-text text-muted check-username"></small>
                    </div> <!-- form-group end.// -->

                      <div class="form-group">
                        <label>Email address</label>
                        <input type="email" class="form-control"  name="email" placeholder="" id="email" value="{{ $user->email }}">
                        <small class="form-text text-muted check-email">We'll never share your email with anyone else.</small>
                      </div> <!-- form-group end.// -->

                        <div class="form-group">
                          <label>Subject</label>
                          <textarea name="subject" class="form-control" id="subject">{{ $user->subject }}</textarea>
                        </div> <!-- form-group end.// -->

                          <div class="form-group">
                            <label>Website</label>
                            <input type="text" name="website" id="website" class="form-control" placeholder=" " value="{{ $user->website }}">
                          </div> <!-- form-group end.// -->

                            <div class="form-row">
                              <div class="form-group col-md-12">
                                <label>Gender</label>
                                <select id="gender"  name="Gender" class="form-control">
                                  <option value = "None" <?php echo  $user->Gender == 'None' ? 'selected' : ''?> > Choose...</option>
                                  <option value = "Male" <?php  echo $user->Gender == 'Male' ? 'selected' : ''?> > Male</option>
                                  <option value = "Female" <?php echo  $user->Gender == 'Female' ? 'selected': '' ?> > Female</option>
                                </select>
                                </div> <!-- form-group end.// -->

                              </div> <!-- form-row.// -->

                                <div class="form-group">
                                  <button type="submit" class="btn btn-primary btn-block" id="saveProfileData"> Save  </button>
                               </div> <!-- form-group// -->

                </form>
              </article> <!-- card-body end .// -->

                        </div> <!-- card.// -->

                      </div> <!-- col.//-->

                    </div> <!-- row.//-->

                </div>
             <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                  <div class="container">
                    <div class="col-md-9">
                     <div class="card">
                           <header class="card-header">
                              <h4>Change Password</h4>
                            </header>

                              <article class="card-body">
                                <section>

                                  <form id="form-password" action="/users/update-pwd" method="post">@csrf @method('put')

                                  <label for="current_pwd">Current Password</label>
                                    <input id="current_pwd" name="current_pwd" type="password" class="required form-control">
                                    <small class="form-text text-muted" id="Chk_pwd"></small>
                                    <label for="new_pwd">New Password</label>
                                    <input id="new_pwd" name="password" type="password" class="required form-control">
                                    <label for="conf_pwd">Confirm Password</label>
                                    <input id="conf_pwd" name="confirm" type="password" class="required form-control">
                                    <br>
                                 <button type="button" id="btn-update" class="btn btn-success">Save</button>
                                  </form>
                                </section>
                              </article>
                            </div>
                          </div>
                   </div>
             </div>
          <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">Soon....</div>

    </div>
  </div>
</div>



<!--container end.//-->

@push('js')
 <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
 <script src="{{ asset('js/toastr/build/toastr.min.js') }}"></script>
 <script>

    $(document).ready(function() {

      $('#email').blur(function() {
          var email = $('#email').val();
          $.ajax({
            url: "{{  url('users/Check-email')  }}",
            type: 'GET',
            data: {email: email},
          })
          .done(function(data) {
            if(email !==''){
                if(data=="false"){
                  $('.check-email').html('<font color="red">Current email is exist</font>');

                  $('#email').css('border-color','red');
                }else{
                    $('#email').css('border-color','green');
                     $('.check-email').html("We'll never share your email with anyone else.");
                }
              }
          })


      });

      //Start Check username
       $('#username').blur(function() {
          var username = $('#username').val();
          $.ajax({
            url: "{{  url('users/Check-username')  }}",
            type: 'GET',
            data: {username: username},
          })
          .done(function(data) {
            if(username !==''){
                if(data=="false"){
                  $('.check-username').html('<font color="red">Current username is exist</font>');

                  $('#username').css('border-color','red');
                }else{
                    $('#username').css('border-color','green');
                     $('.check-username').html("");
                }
              }
          })


      });
       //End Check username

          //Check password if correct
          $("#conf_pwd").keyup(function(){
            var conf = $('#conf_pwd').val();
            var newP = $('#new_pwd').val();
            if (conf == newP) {
                $('#conf_pwd').css('border-color','green');
                $('#new_pwd').css('border-color','green');
            }else{
                $('#conf_pwd').css('border-color','red');
            }

        });

          $('#current_pwd').blur(function() {
            var current_pwd = $('#current_pwd').val();
            var new_pass = $('#new_pwd').val();

            $.ajax({
              url: '{{ url('users/Check-password') }}',
              type: 'GET',
              data: {current_pwd: current_pwd},
            })
            .done(function(data) {
              if(current_pwd !==''){
              if(data=="false"){
                $('#Chk_pwd').html('<font color="red">Current password is not correct</font>');
                $('#Chk_pwd').show();
                $('#current_pwd').css('border-color','red');
              }else{
                  $('#current_pwd').css('border-color','green');
                  $('#Chk_pwd').hide();
              }
            }
            })
            .fail(function() {
              console.log("error");
            })


          });

         //End Check password if correct

         //Strart submit data form password
          $('#btn-update').click(function() {
            var current_pwd = $('#current_pwd').val();
            var new_pass = $('#new_pwd').val();
            var _token = $("input[name='_token']").val();
            var error_html = '';
            if(current_pwd !== '' && new_pass !==''){
            $.ajax({
              url: '{{ url('users/update-pwd') }}',
              type: 'post',
              dataType:'json',
              data: {current_pwd: current_pwd,password:new_pass,_token:_token},
            })
            .done(function(data) {


              if(data.error.constructor == Array && data.error.length>0){

                for ( var count = 0; count <data.error.length ; count++){
                  // error_html +=  '<div class="alert alert-danger alert-dismissible" id="error">'+
                  // '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
                  // '<strong>Oh!</strong> Enter '+data.error[count] +'and try again. '+
                  //  '</div> ';

                   toastr.error(data.error[count], 'Error');

                }
               // $('#error').html(error_html);

              }

             if(data.error.constructor !== Array){
                 toastr.error(data.error, 'Error');
              }

              if(data.success.length > 0){
              //  var  success = '<div class="alert alert-success alert-dismissible" id="success">'+
              //    '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
              //     '<strong>Oh!</strong> Enter '+data.success +'and try again. '+
              // '</div>';
              //    $('#error').html(success);
                 toastr.success(data.success, 'Successfully');
                $('#form-password')[0].reset();
              }

            })
            .fail(function() {
              console.log("error");
            })
            }else{
              $('#new_pwd').css('border-color','red');
              $('#conf_pwd').css('border-color','red');
              $('#current_pwd').css('border-color','red');
              console.log(5);
            }

          });
         //End submit data form password


           //Start submit data form edit profile
           $('#saveProfileData').click(function(e) {
              e.preventDefault();

            var name = $('#name').val();
            var username = $('#username').val();
            var email = $('#email').val();
            var subject = $('#subject').val();
            var website = $('#website').val();
            var gender = $('#gender').val();
            // var new_pass = $('#new_pwd').val();
            var _token = $("input[name='_token']").val();
            var error_html = '';
            $.ajax({
              url: "{{url('users/'.$user->id)}}",
              type: 'post',
              dataType:'json',
              headers: {
                    'X-CSRF-TOKEN':_token,
                },
              data: {
                     _method: 'PUT',
                     name: name,
                     username: username,
                     email:email,
                     subject:subject,
                     website:website,
                     Gender:gender
                },
            })
            .done(function(data) {
                kvArray = [data.error];
                for(var key in kvArray ) {
                    for (const key2 in kvArray[key]) {
                        toastr.error(kvArray[key][key2][0], 'Note:');
                         $(`#${key2}`).css('border-color','red');
                    }
                }
                // for ( var count = 0; count <data.error.length ; count++){
                //    toastr.error(data.error[count], 'Error');
                // }
                if(data.error.constructor !== Object && data.error != ''){
                    toastr.error(data.error, 'Note:');
                }

              if(data.success.length > 0){
                 toastr.success(data.success, 'Successfully');
                //  $('#form-password')[0].reset();
              }

            })
            .fail(function() {
              console.log("error");
            })


          });
         //End submit data form edit profile




    });

 </script>
@endpush

@endsection
