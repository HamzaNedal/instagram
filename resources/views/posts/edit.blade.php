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
<article class="card-body mx-auto" style="max-width: 400px;">
	<h4 class="card-title mt-3 text-center">Edit Post</h4>
	<form action="/posts/{{ $id }}" accept-charset="utf-8" enctype="multipart/form-data"> @csrf
		@method('put')

	 <div id="click" class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-file"></i> </span>
		    
		</div>
		 <img   class="form-control" src="{{ asset('image/upload.png') }}" alt="">
        <input class="form-control d-none" id="ValidPhotoProfile" type="file" name="image[]" multiple>
       
    </div> <!-- form-group// -->
                                    
    <div class="form-group">
        <input type="submit" class="btn btn-primary btn-block" value="Edit Post ">  
    </div>     
	</form>
      
      <div class="form-group">
         @foreach ($photos as $photo)
        	 <img   style="width: 100px;height: 100px;" src="{{ asset('files/'.$photo->photo) }}" alt="image">
        @endforeach
    </div>                                                      

</article>
</div> <!-- card.// -->

</div> 
<!--container end.//-->

@push('js')
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script>
  			$(document).ready(function() {
  				$('#click').click(function(){
  					 document.getElementById('ValidPhotoProfile').click();
  					
  				});
  			});
  		</script>

<!------ Include the above in your HEAD tag ---------->
@endpush
@endsection