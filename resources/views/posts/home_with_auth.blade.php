
     @php
        $show_post_by_follow = \App\Follow::where(['followers'=>auth::user()->id , 'following' => $post->UserId->id])->first();
     @endphp
   
   
   @if ($show_post_by_follow !== null || auth::user()->id == $post->UserId->id)
       
      
       <div class="card" style="margin-top: 10px">
        <div class="card-header">
          <div class="_post">

            <a class="_2dbep" href="users/{{  $post->UserId->username  }}">
              <img class="Profile_Image" src="{{ asset('profile/'.$post->userId->photo) }}" alt="Profile_Image">

            </a>
            <a class="name_profile" href="users/{{ $post->UserId->username }}">{{ $post->UserId->name }}</a>
          </div>
          @if (isset(auth::user()->username))
           @if (auth::user()->id == $post->user_id)

           <div class="dropdown edit-post">
              <button class="btn  float-right fas fa-ellipsis-v" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               
            
              </button>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                {{-- <a class="dropdown-item" href=" {{ url('posts/'.$post->id) }}/edit">Edit</a> --}}
                <form action="{{ url('posts/'.$post->id) }}" method='post' accept-charset="utf-8">@csrf @method('Delete')
                  <input type='submit' class="dropdown-item"  value="Delete">
                 
                </form>
                
              
              </div>
             
             
            </div>
             
             @endif
             @endif 
                   @php
                     $time = round((strtotime(now())-strtotime($post->created_at)));
                     
                    @endphp

                 @switch($time)
                     @case($time < 60)
                          <a class="date-post" href="#" title="{{ date('D j F Y',strtotime($post->created_at)) }}"><small>{{  $time }} sec</small></a>
                         @break
                     @case($time/60 < 60)
                          <a class="date-post" href="#" title="{{ date('D j F Y',strtotime($post->created_at)) }}"><small>{{  round($time/60) }} min</small></a>
                         @break
                     @case($time/60/60 <= 24)
                     @if (round($time/60/60) == 1)
                       <a class="date-post" href="#" title="{{ date('D j F Y',strtotime($post->created_at)) }}"><small>{{  round($time/60/60) }} hr</small></a>
                       @else
                       <a class="date-post" href="#" title="{{ date('D j F Y',strtotime($post->created_at)) }}"><small>{{  round($time/60/60) }} hrs</small></a>
                     @endif
                         
                         @break
                     @case($time/60/60/24 < 7)
                          <a class="date-post" href="#" title="{{ date('D j F Y',strtotime($post->created_at)) }}"><small>{{  round($time/60/60/24) }} d</small></a>
                         @break
                     @case($time/60/60/24/7 <= 4)
                          <a class="date-post" href="#" title="{{ date('D j F Y',strtotime($post->created_at)) }}"><small>{{  round($time/60/60/24/7) }} w</small></a>
                         @break 
                     @case($time/60/60/24/30 <= 12)
                          <a class="date-post" href="#" title="{{ date('D j F Y',strtotime($post->created_at)) }}"><small>{{  round($time/60/60/24/30) }} m</small></a>
                         @break
                     @default
                          <a class="date-post" href="#" title="{{ date('D j F Y',strtotime($post->created_at)) }}"><small>{{  round($time/60/60/24/365) }} y</small></a>
                 @endswitch
        </div>
        <div class="card-body">

          <div id="carousel-{{ md5($post->id) }}" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
              {{-- number of photos --}}
              <?php $count_photo = 0?>

              @foreach ($photos as $photo)

              @if ($photo->post_id == $post->id)

                <div class="carousel-item  <?php echo $count_photo==0 ? 'active' : ""  ?>">
                  <a href="{{ asset('files/'.$photo->photo) }}" target="_blank">
                  <img class="d-block w-100" style="width:100%" src="{{ asset('files/'.$photo->photo) }}" alt="First slide">
                  </a>
                </div>

              
                <?php $count_photo++?>
              @endif
                
              @endforeach 
             
            

            </div>

            @if ($count_photo>1)

            <a class="carousel-control-prev" href="#carousel-{{ md5($post->id) }}" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>

            <a class="carousel-control-next" href="#carousel-{{ md5($post->id) }}" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
             
            @endif
           
          </div>
              <div class="Click_Like_comment">

            @if (isset(auth::user()->username))
            <form class="formLike"  method="post" accept-charset="utf-8"> @csrf

                <?php $like = \App\Likes::where(['post_id'=>$post->id,'user_id'=>auth::user()->id])->first(); ?>
                @if ($like !== null)
                
                 @if ($like->status == "like")
                      <i class="fa fa-heart icon like">
                        <input type="button"  class="d-none" name="like" value="unlike">
                      </i> 
                    @else
                   
                      <i class="fa fa-heart-o icon unlike">
                        <input type="button"  class="d-none" name="like" value="like">
                      </i> 
                 @endif
                 @else

                  <i class="fa fa-heart-o icon unlike">
                     <input type="button"  class="d-none" name="like" value="like">
                 </i> 
                 
                @endif
                
              @endif
             
           
             
              <input type="hidden" name="posts" value="{{ $post->id }}">
           
            </form>
             @if (isset(auth::user()->username))
           <a href="#comment-{{ $count_comment }}" style="margin-left: 35px;"><i class="fa fa-comment-o icon-comment"></i></a>
           <a ><i id="share" class="fa fa-share icon-share"></i></a> 
           @endif
         </div>
         <div class="LikeCount">
        
         
            @auth('web')
            @php
              $likecount = \App\Likes::where(['post_id'=>$post->id,'status'=>'like'])->get();
            @endphp
            
            @if (count($likecount)>0)
              <a href="#" data-toggle="modal" data-target="#{{ md5($post->id) }}" class="likeCount">{{ count($likecount)}} Like</a>
            @endif
          

            <!-- Modal -->
              <div class="modal fade" id="{{ md5($post->id)  }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">People</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <p aria-hidden="true">&times;</p>
                      </button>
                    </div>
                    <div class="modal-body">
                     
                     @foreach ($post->likePost as $like)

                      @if ($like->status == 'like')

                        <p>
                            <a href="{{ url('users/'.$like->UserId->username) }}" >{{ $like->UserId->username }}</a>

                        </p> 
                        
                     
                       
                        @endif
                      @endforeach
                      
                    </div>
   
                  </div>
                </div>
              </div>

               @endauth


         </div>
         @if (count($post->commentPost) > 0)
        <div class="more-comment">
                <span class="d-none post_id">{{ $post->id }}</span>
                 <a href="#" title=""> <i class="fa fa-reply" style="transform: rotateZ(180deg);"></i> {{ count($post->commentPost)  }} Comments</a>
         </div>
     @endif
         <div class="showComments">

         </div>
         
         <div>

           @if (isset(auth::user()->username))
          <form class="commentForm" method="post" accept-charset="utf-8"> @csrf
             
             {{-- <input type="submit"  class="d-none comment" value="comment" class="send"> --}}
           
            <input type="hidden" name="post" class="post" value="{{ $post->id }}">
             {{-- <i class="fas fa-chevron-circle-right icon-comment click-comment clickComment"></i> --}}
             <textarea placeholder="Write a comment" name="comment" class="form-control keyComment" id="comment-{{ $count_comment }}"></textarea>
            
          </form> 
          @endif
        </div>

      </div>
        </div>

       
   @endif
   