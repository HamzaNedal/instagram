 <div class="card" style="margin-top: 10px">
        <div class="card-header">
          <div class="_post">

            <a class="_2dbep" href="users/{{  $post->UserId->username  }}">
              <img class="Profile_Image" src="{{ asset('profile/'.$post->userId->photo) }}" alt="Profile_Image">

            </a>
            <a class="name_profile" href="users/{{ $post->UserId->username }}">{{ $post->UserId->name }}</a>
          </div>
       
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

          <div id="carousel-{{md5($post->id)  }}" class="carousel slide" data-ride="carousel">
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
         
         <div>
        
         
           
            @php
              $likecount = \App\Likes::where(['post_id'=>$post->id,'status'=>'like'])->get();
            @endphp
            
            @if (count($likecount)>0)
              <a href="{{ url('/login') }}"  class="likeCount">{{ count($likecount)}} Like</a>
            @endif

             


         </div>
          
         <div class="showComments">
          @include('posts.showComments')
         </div>
         

      </div>
        </div>

       <?php $count_comment++;?>

   