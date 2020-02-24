 @if (\App\Follow::where(['followers'=>$user->id])->get()->count() !==0)
				
 
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