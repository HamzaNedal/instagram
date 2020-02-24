	@extends('layouts.app')

	@section('content')
	@push('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('js/toastr/build/toastr.min.css') }}">
	<style>
		.img_profile{
			 border-radius: 160px;
			 width: 150px;
			 height: 150px;

	 }
	 .card_edit{
			position: relative;
			display: -webkit-box;
			display: -ms-flexbox;
			display: flex;
			-ms-flex-direction: column;
			flex-direction: column;
			left:-10%;
	 }
	 .info{
		    position: relative;
            left: 10%;
            top: -59%;
	 }
	 .info > a[href='#'] , .info > span {
			font-size: 18px;
				 margin-left: 40px;
	 }
	 .edit-profile{
			position: relative;
			top: -20px;
			margin-top: -22px;
			margin-left: 149px;
	 }
	._profileStyle{
		margin-top: 30px;
			margin-left: 95px;
				 height: 205px;
	 }
	</style>

	@endpush
		<div class="container">
			<div class="_profileStyle">


			<div id="click" class="card_edit" style="width: 10rem;" >

				<img class="img_profile" src="{{ asset('profile/'.$user->photo) }}" alt="">
				 @if (isset(auth::user()->id))
					@if ($user->id == auth::user()->id)

							<div class="d-none">
								<form method="post" action="{{ url('users/update-image') }}" id="upload_form" accept-charset="utf-8" enctype="multipart/form-data">@csrf @method('put')
									<input type="file" name="photo" id="ValidPhotoProfile">
									<input type="submit"  class='d-none' name="" id="submit">
								</form>
							</div>
						@endif
				 @endif
			</div>

			<div class="info">
				 @if (isset(auth::user()->id))
					<h2 >{{ $user->username }}</h2>
				@else
					<h2 style="margin-bottom: 35px;">{{ $user->username }}</h2>
				@endif

				<div class="edit-profile">

						@if (isset(auth::user()->id))

							@if ($user->id == auth::user()->id)
							<a href="{{ url('users/'.$user->id) }}/edit" class="btn btn-outline-dark">Edit Profile</a>
							@endif
						@endif

					{{-- Strat Form --}}
				@if (isset(auth::user()->id))
						<form class="formFollow" method="post" accept-charset="utf-8">@csrf
							<input type="hidden" name="user_follow" value="{{ $user->id }}">
							@if ($user->id !== auth::user()->id)
							<?php $follow = \App\Follow::where(['followers'=>auth::user()->id,'following'=>$user->id])->first() ?>

								@if ($follow !== null)
									{{-- <input type="submit"  class="btn btn-primary" value='UnFollow'> --}}
									<input type="button"  class="btn btn-outline-secondary btn_Follow"  value='UnFollow'>
								@else
									{{-- <input type="submit"  class="btn btn-primary" value='Follow'> --}}
									<input type="button"  class="btn btn-primary btn_Follow"  value='Follow'>
							@endif

                             <a type="button" class="btn btn-outline-primary" href="{{ url('/messages/ChatUser/'.$user->id) }}">Message</a>
							@endif


						</form>
				@endif
					 {{-- End Form --}}
				</div>

				<span><strong>{{ \App\Posts::where('user_id', $user->id)->get()->count() }} </strong> posts</span>
			 @if (\App\Follow::where(['followers'=>$user->id])->get()->count() !==0)
				 {{-- expr --}}

				<a href='#'data-toggle="modal" data-target="#following"><strong>{{ \App\Follow::where(['followers'=>$user->id])->get()->count() }}</strong> Following</a>

							<!-- Modal -->
							<div class="modal fade" id="following" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLongTitle">Following</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<p aria-hidden="true">&times;</p>
											</button>
										</div>
										<div class="modal-body">
											<?php $follows =  \App\Follow::get(); ?>
											@foreach ($follows as $follow)

											@if ($follow->followers == $user->id)

											 </p>
											 <a href="{{ url('users/'.$follow->follow_ing->username) }}" >{{ $follow->follow_ing->username }}</a>
											 <p>


											@endif


											@endforeach

										</div>

									</div>
								</div>
							</div>
							@else
							<span><strong>{{ \App\Follow::where(['followers'=>$user->id])->get()->count() }}</strong> Following</span>

					@endif


				@if (\App\Follow::where(['following'=>$user->id])->get()->count() !== 0)
				<a href="#" data-toggle="modal" data-target="#test"><strong>{{ \App\Follow::where(['following'=>$user->id])->get()->count() }}</strong> Followers</a>

							<!-- Modal -->
							<div class="modal fade" id="test" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLongTitle">Followers</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<p aria-hidden="true">&times;</p>
											</button>
										</div>
										<div class="modal-body">
										 	<?php $follows =  \App\Follow::get(); ?>
											@foreach ($follows as $follow)

											@if ($follow->following == $user->id)

												<p>
												<a href="{{ url('users/'.$follow->follow->username) }}" >{{ $follow->follow->username }}</a>

												</p>

											@endif


											@endforeach

										</div>

									</div>
								</div>
							</div>
							@else
							 <span><strong>{{ \App\Follow::where(['following'=>$user->id])->get()->count() }}</strong> followers</span>

				@endif


				{{-- Info user --}}
				<div style="margin-top: 13px">
					<h3> {{ $user->name }} </h3>
					<h6>{{  $user->subject }}</h6>
					<a href="{{ $user->website }}">{{ $user->website }}</a>
				</div>

			</div>

		</div>
			<hr>
		@if (isset(auth::user()->id))
			@if ($user->id == auth::user()->id)
				 <a href="{{ url('posts/create') }}" class="btn btn-outline-dark">Create Post</a>
			@endif
			{{-- get posts --}}
			 @include('users.showMyPost')
			{{-- End get posts --}}
		@endif

		</div>
		@push('js')
		{{-- <script src="{{ asset('fontawesome/js/all.min.js') }}"></script> --}}
		<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
		<script src="{{ asset('js/toastr/build/toastr.min.js') }}"></script>
	@if (isset(auth::user()->username))
			<script>
				$(document).ready(function() {
					$('#click').click(function(){
						 document.getElementById('ValidPhotoProfile').click();

					});

					$('#click').change(function(){


						 document.getElementById('submit').click();

					});

					//Start Click Follow
					$('.btn_Follow').click(function() {
						//var like = $(this).children("input[name='like']").val();
						var _token = $(this).parent().children("input[name='_token']").val();
						var user_id = $(this).parent().children("input[name='user_follow']").val();
						var btn_Follow = $(this).val();
						 if(btn_Follow == 'UnFollow'){
								$(this).val('Follow');
								$(this).addClass('btn-primary');
								$(this).removeClass('btn-outline-secondary');
						 }else{
								$(this).val('UnFollow');
								$(this).addClass('btn-outline-secondary');
								$(this).removeClass('btn-primary');

						 }
						 if(typeof _token !== 'undefined' && typeof user_id !== 'undefined'){
						 	$.ajax({
							url: '{{ url('users/follow') }}',
							type: 'Post',
							data: {_token:_token,user_id:user_id},
						}).done(function (data) {
							if (data !== "true") {
								console.log(data);
								toastr.error(data, 'Error');
							}

						});
						 }




					});
					// End Click Follow


				});
			</script>
	@endif
		@endpush
	@endsection
