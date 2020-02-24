@extends('layouts.app')

@section('content')
@push('css')
	
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
<style>
	.divider-text {
    position: relative;
    text-align: center;
    margin-top: 15px;
    margin-bottom: 15px;
}
.divider-text span {
    padding: 7px;
    font-size: 12px;
    position: relative;   
    z-index: 2;
}
.divider-text:after {
    content: "";
    position: absolute;
    width: 100%;
    border-bottom: 1px solid #ddd;
    top: 55%;
    left: 0;
    z-index: 1;
}

.btn-facebook {
    background-color: #405D9D;
    color: #fff;
}
.btn-twitter {
    background-color: #42AEEC;
    color: #fff;
}
</style>

@endpush
<div class="container">


<div class="card bg-light">
  <div class="form-group uploadImageLine">

  </div>
<article class="card-body mx-auto" style="max-width: 400px;">
	<h4 class="card-title mt-3 text-center">Create Post</h4>
<form action="{{ route('posts.store') }}" id="formCreate" class="formCreate" method="post" accept-charset="utf-8" enctype="multipart/form-data"> @csrf
    
	 <div id="click" class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-file"></i> </span>
		    
		</div>
		 <img   class="form-control" src="{{ asset('image/upload.png') }}" alt="">
        <input class="form-control d-none" id="ValidPhotoProfile" type="file" name="image[]" multiple>

    </div> <!-- form-group// -->
                                    
    <div class="form-group img">
       
    </div> <!-- form-group// -->

    <div class="form-group">
        <input type="submit" class="btn btn-primary btn-block btn_create_post" value="Create Post ">  
    </div> <!-- form-group// -->   
	</form>
      
                                                                   

</article>
</div> <!-- card.// -->

</div> 
<!--container end.//-->

@push('js')
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script> 
	<script>
  			$(document).ready(function() {
  				$('#click').click(function(){
  					 document.getElementById('ValidPhotoProfile').click();
  					
  				});
          $('#ValidPhotoProfile').change(function() {
                $('.formCreate').ajaxForm({

                  beforeSend:function(){
                    
                    $('.uploadImageLine').html(` <div class="progress-bar" role="progressbar" aria-valuenow=""
                  aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                    0%
                  </div>`);
                    
                
                      $('#success').empty();
                  },
                  uploadProgress:function(event, position, total, percentComplete)
                  {
                    // console.log(percentComplete);
                      $('.progress-bar').text(percentComplete + '%');
                      $('.progress-bar').css('width', percentComplete + '%');
                  },
                  success:function(data)
                  {
                    location.href = '/';
                  },
                  error: function (req, textStatus, errorThrown) {
                          $('.progress-bar').text('Failed!!');
                          $('.progress-bar').css('width', '100%');
                          $('.progress-bar').css('background-color', 'red');
                  }
                });
             
               // console.log();
              //readURL(this);
              var imgItem = $(this)[0].files;
              var imgCount = $(this)[0].files.length;
              var imgPath = $(this)[0].value;
              var imgExt= imgPath.substring(imgPath.lastIndexOf('.')+1).toLowerCase();
              var imgPreview= $('.img');
              imgPreview.empty();
              if (imgExt =='gif' || imgExt =='jpg' || imgExt =='png' || imgExt =='jpeg'|| imgExt =='bmp') {
                
                if (typeof(FileReader) !='undefined' ) {
                     
                  for (var i = 0; i < imgCount; i++) {

                    var reader = new FileReader();
                    var fn = imgItem[i].name;
                    var fs = imgItem[i].size;
                    var ft = imgItem[i].type;

                    reader.onload = function(e){
                      $('<img />',{
                        'src':e.target.result,
                        'width':"50px",
                        'height':"50px",
                        'title':fn+" and size "+fs+" bytes and type "+ft,
                        'alt':fn+" and size "+fs+" bytes and type "+ft,
                      }).appendTo(imgPreview);
                     
                    }
                     //imgPreview.show();
                     //  console.log($(this)[0]);
                      reader.readAsDataURL($(this)[0].files[i]);
                  }
                }else{
                  imgPreview.html('Nothing');
                }
              }else{
                imgPreview.html('Pleace enter just image');
              }
             
   
              
          });

       

         // var myForm = document.getElementById('formCreate');
          //  $('.btn_create_post').on('click', function(event) {
          //       event.preventDefault();
          //      // var form = new FormData(myForm);
          //    //  form.append( 'image', $('#ValidPhotoProfile').val() );
    
          //    //  console.log(form.get('image[]')); 
                   
                                            
          //      // console.log(form.values());
          //    //   $('.img').html("<img src='"+$('#ValidPhotoProfile').val()+"' >")
          // });
        // function readURL(input) {

         
        //     var reader = new FileReader();
           
        //     reader.onload = function(e) {
        //        // <img src="" alt="" id="img" style="width: 50px;height: 50px">
        //       console.log(e.target);
        //     }
        //     for (var i = 0; i < input.files.length; i++) {
        //       reader.readAsDataURL(input.files[i]);
        //     }
            
        //   }
        

  			});
  		</script>

<!------ Include the above in your HEAD tag ---------->
@endpush
@endsection