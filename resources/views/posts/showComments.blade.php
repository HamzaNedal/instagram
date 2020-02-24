


@auth('web')


   
    <script>
  $(document).ready(function() {

       var commentShow =  $('.comment-span');
          var arr_comment = [];
          for (var i = 0; i < commentShow.length; i++) {
                 arr_comment[i] = commentShow[i].innerHTML;
                var comment_val = commentShow[i].innerHTML;
        
              if (comment_val.length > 100) {
                    var comment_cut = comment_val.substring(0,100);

                    commentShow[i].innerHTML = comment_cut+"...<a href='#' class='more'>More</a>";
                   
              }
          }

             //Start show all comment
          $(".more").on('click', function (e){
            e.preventDefault();
         
            var dataCommentNumber = $(this).parent().data("comment");
           number_comment = dataCommentNumber.replace('comment_','')-1;
         
           //End edit and delete Comment 
          var height = $(this).parent().parent().parent();
          var children = $(this).parent().parent().parent().children().children('.ellipsis');

          //show all comment
          $(this).parent().html(arr_comment[number_comment]);

          var margin_top = (height.height()+8)*-1;
          children.css('margin-top',margin_top);
        
           //End edit and delete Comment 
           
          });
          //End show all comment

          //Edit and Delete Comment
           var comment_span = $('.dropdown').parent().children('.height-span');
           
           var count_div_dropdwon_for_height = 0;
           for (var i = 0; i < comment_span.length; i++) {

               var margin_top =  (comment_span[i].offsetHeight+8)*-1;
                document.getElementsByClassName('ellipsis')[i].style.marginTop = margin_top+"px";

           }
        //End edit and delete Comment 

     //Start Edit comment 

        $('.Edit-comment').hide();
         $(document).on('click', ".dropdown-item-comment-edit", function (e){
              e.preventDefault();
              var btn =  $(this).parent().siblings('.Edit-comment');
               var dataCommentNumber = $(this).parent().parent().siblings('.height-span').children('.comment-span').data("comment");
        if (typeof dataCommentNumber !=='undefined') {
           var  number_comment = dataCommentNumber.replace('comment_','')-1;
        }
            

            var hasClassMore =    $(this).parent().parent().siblings('.height-span').children('.comment-span').children('a').hasClass('more');
               
                $(".ellipsis").show();
                $(".height-span").show();
                $(".Edit-comment").hide();
                 $(".likeComment").hide();
                $(this).parent().parent().children('.ellipsis').hide();
                $(this).parent().parent().parent().children('.height-span').hide();
                 if (!hasClassMore) {
                 
                    $(this).parent().siblings('.Edit-comment').children('.comment-edit').html($(this).parent().parent().siblings('.height-span').children('.comment-span').children('a').html());
                    $(this).parent().parent().children('.Edit-comment').show();

                 }else if(hasClassMore){
                   var dataCommentNumber = $(this).parent().parent().siblings('.height-span').children('.comment-span').data("comment");
                   number_comment = dataCommentNumber.replace('comment_','')-1;
                   $(this).parent().siblings('.Edit-comment').children('.comment-edit').html(arr_comment[number_comment]);
                     $(this).parent().parent().children('.Edit-comment').show();

                 }else{
                     $(this).parent().parent().children('.Edit-comment').show();
                 }
                

                 $(btn.children('.cancel')).unbind().bind('click', function(){

                  
                   $(".ellipsis").show();
                    $(".height-span").show();
                     $(".likeComment").show();
                    $(".Edit-comment").hide();

                });

                
              $(btn.children('.save')).unbind().bind('click' ,function (){
                  
                        var comment_span = $(this).parent().parent().siblings('.height-span').children('.comment-span');
                        var comment_edit = $(this).siblings('.comment-edit').val();
                        var comment_id = $(this).siblings('.comment_id').val();
                        $(".ellipsis").show();
                        $(".height-span").show();
                         $(".likeComment").show();
                        $(".Edit-comment").hide();

                         
                           $.ajax({
                             url: '{{ url('posts/update-comment') }}',
                             type: 'get',
                             dataType: 'json',
                             data: {comment: comment_edit,comment_id:comment_id},
                           }).done(function (data) {
                             
                                 if (data !== false) {comment_span.html(data);}

                           })
                          
                });

        });

         $('body').keydown(function(e) {
           if (e.keyCode == 27) {
                   $(".ellipsis").show();
                    $(".height-span").show();
                    $(".Edit-comment").hide();
                     $(".likeComment").show();
                 }
         });  
         
      $('.comment-edit').keydown(function(e) {
          var key = e.which;
        
           if (key == 13 && e.shiftKey == false) {
                       var comment_span = $(this).parent().parent().siblings('.height-span').children('.comment-span');
                        var comment_edit = $(this).val();
                        var comment_id = $(this).siblings('.comment_id').val();
                        $(".ellipsis").show();
                        $(".height-span").show();
                         $(".likeComment").show();
                        $(".Edit-comment").hide();
                       

                           $.ajax({
                             url: '{{ url('posts/update-comment') }}',
                             type: 'get',
                             dataType: 'json',
                             data: {comment: comment_edit,comment_id:comment_id},
                           }).done(function (data) {
                             
                              if (data !== false) {comment_span.html(data);}
                                
                                 
                                
                               
                           })
                 }
         });

         //End Edit comment


       //Start Delete Comment 
        $(document).on('click', ".dropdown-item-comment-delete", function (e){
          
          e.preventDefault();
           var delComment =  $(this).siblings('.comment_id').val();
           $(this).parent().parent().parent().remove('div');
          
            $.ajax({
                   url: '{{ url('posts/delete-comment') }}',
                   type: 'get',
                   dataType: 'json',
                   data: {comment_id:delComment},
                 })
             
                
        });
       //End Delete Comment 

         @if ($count == 1)
       //Start Like Comment
         $(document).on('click', ".btn_like_comment", function (e){
            var like_comment = $(this);
          e.preventDefault();
            var comment_id =  $(this).siblings('.comment_id').html();
            
             
          if($(this).css('color') == 'rgb(255, 0, 0)'){

                like_comment.css('color','blue')
             
             }else{
                like_comment.css('color','red')
                
             }
            $.ajax({
                   url: '{{ url('posts/like-comment') }}',
                   type: 'get',
                   dataType: 'json',
                   data: {comment_id:comment_id},
                 })
             
                
        });
       //End Like Comment 
        @endif

  });</script>

 {{-- //Strat Reply Comment --}}
  <script>
      $(document).ready(function() {
        
         $(".Reply").unbind().bind('click', function (e){
            
           
          e.preventDefault();
          if ($(this).parent().siblings('.write_reply').hasClass('d-none')) {
            $(this).parent().siblings('.write_reply').removeClass('d-none');
          }else{
             $(this).parent().siblings('.write_reply').addClass('d-none');
          }
         // console.log( $(this).parent().siblings('.write_reply').hasClass('d-none'));
          });

          $('.LikeComment').unbind().bind('keypress' ,function (e){
            var Show_Reply_Comment = $(this).parent().parent().siblings('.Show_Reply_Comment');

             var key = e.which;
            if (e.keyCode == 27) {
               $(this).blur();
               $(this).parent().parent().addClass('d-none');
            }
            var replyForm =  $(this).parent('.replyForm');
           if (key == 13 && e.shiftKey == false) {
             var comment_id = $(this).siblings('.comment').val();
             var replyComment = $(this).val();

             $(this).parent().parent().addClass('d-none');

             $.ajax({
               url: '{{ url('posts/reply-comment') }}',
               type: 'get',
               dataType: 'json',
               data: {comment_id:comment_id,replyComment:replyComment},
             })
             .done(function(data) {
              
                  Show_Reply_Comment.append(data);
             })
             replyForm[0].reset();
           }
           
          });
      

        //start edit reply comment
        $('.Edit-reply').hide();
         $(document).on('click','.dropdown-item-reply-edit', function (e){

                e.preventDefault();
                var dropdown = $(this).parent().parent();
                
                dropdown.children('.ellipsis-reply').hide();
                dropdown.children('.Edit-reply').show();
                dropdown.siblings('.media-body').hide();
               
              
                 var Check_link = dropdown.siblings('.media-body').children('.re_comment').children('a');
                
                 if (Check_link) {

                    dropdown.children('.Edit-reply').children('.reply-edit').html(Check_link.html());

                   }
                

                 $('.cancel').unbind().bind('click', function(){
                    var dropdown_Edit_reply = $(this).parent().parent();
                    dropdown_Edit_reply.children('.ellipsis-reply').show();
                    dropdown_Edit_reply.children('.Edit-reply').hide();
                    dropdown_Edit_reply.siblings('.media-body').show();
            
                });

                
              $('.save').unbind().bind('click' ,function (){
                        var dropdown_Edit_reply = $(this).parent().parent();
                        
                        var reply_id = $(this).siblings('.reply_id').val();
                        var reply = $(this).siblings('.reply-edit').val();
                        
                        dropdown_Edit_reply.children('.ellipsis-reply').show();
                        dropdown_Edit_reply.children('.Edit-reply').hide();
                        dropdown_Edit_reply.siblings('.media-body').show();
                        reply_update = dropdown_Edit_reply.siblings('.media-body').children('.re_comment');
                        //  dropdown_Edit_reply.siblings('.media-body').children('.re_comment').html(reply);
                           $.ajax({
                             url: '{{ url('posts/update-reply') }}',
                             type: 'get',
                             dataType: 'json',
                             data: {reply_id: reply_id,reply:reply},
                           }).done(function (data) {
                             
                                 if (data !== false) {reply_update.html(data);}

                           })
                          
                });

        });

         $('body').keydown(function(e) {
           if (e.keyCode == 27) {
                   $(".ellipsis-reply").show();
                    $(".media-body").show();
                    $(".Edit-reply").hide();
                     
                 }
         });  
         
  

         //End Edit reply comment


       //Start Delete Comment 
        $(document).on('click', ".dropdown-item-reply-delete", function (e){
          
          e.preventDefault();
           var delreply =  $(this).siblings('.reply_id').val();
           $(this).parent().parent().parent().remove('div');
          
            $.ajax({
                   url: '{{ url('posts/delete-reply') }}',
                   type: 'get',
                   dataType: 'json',
                   data: {reply_id:delreply},
                 })

        });
       //End Delete Comment 

       //start show all reply

          $(document).on('click', '.more-reply a', function(event) {
            var comment_id = $(this).parent().siblings('.likeComment').children('.comment_id').html();
            {{-- {{ url('posts/Show-Reply-Comment/'+comment_id) }} --}}

            var url_all_reply = "http://"+location.host+'/posts/Show-Reply-Comment/'+comment_id;
            event.preventDefault();

            $(this).parent().siblings('.Show_Reply_Comment').load(url_all_reply);
             $(this).parent().remove();
            
          });

       //End show all reply
      });</script>
{{--   //End Reply Comment --}}

 


@endauth

@php
  $data_comment = 1;
@endphp

            
           @foreach ($comments as $comment)
              @if ($comment->post_id == $post->id)
              <div>
                <a href="{{ url('users/'.$comment->UserId->username) }}" >
                  <img  src="{{ asset('profile/'.$comment->UserId->photo) }}" alt="">
                </a> 
                <span class="height-span">

                   <a style="font-weight: 700;
                    color: #0a55e4;" href="{{ url('users/'.$comment->UserId->username) }}" >{{  $comment->UserId->name }}</a>
                      {{-- date('j F Y', ) --}}
                    <p class="comment-span" data-comment='comment_{{ $data_comment}}'>{!! $comment->comments !!}</p> 
                    @php
                     $time = round((strtotime(now())-strtotime($comment->created_at)));
                     $timeMinute = round((strtotime(now())-strtotime($comment->created_at))/60);
                     $timeHour = round((strtotime(now())-strtotime($comment->created_at))/60/60);
                    @endphp

                 @switch($time)
                     @case($time < 60)
                          <a href="#" title="{{ date('D j F Y',strtotime($comment->created_at)) }}"><small>{{  $time }} sec</small></a>
                         @break
                     @case($time/60 < 60)
                          <a href="#" title="{{ date('D j F Y',strtotime($comment->created_at)) }}"><small>{{  round($time/60) }} min</small></a>
                         @break
                     @case($time/60/60 <= 24)
                     @if (round($time/60/60) == 1)
                       <a href="#" title="{{ date('D j F Y',strtotime($comment->created_at)) }}"><small>{{  round($time/60/60) }} hr</small></a>
                       @else
                       <a href="#" title="{{ date('D j F Y',strtotime($comment->created_at)) }}"><small>{{  round($time/60/60) }} hrs</small></a>
                     @endif
                         
                         @break
                     @case($time/60/60/24 < 7)
                          <a href="#" title="{{ date('D j F Y',strtotime($comment->created_at)) }}"><small>{{  round($time/60/60/24) }} d</small></a>
                         @break
                     @case($time/60/60/24/7 <= 4)
                          <a href="#" title="{{ date('D j F Y',strtotime($comment->created_at)) }}"><small>{{  round($time/60/60/24/7) }} w</small></a>
                         @break 
                     @case($time/60/60/24/30 <= 12)
                          <a href="#" title="{{ date('D j F Y',strtotime($comment->created_at)) }}"><small>{{  round($time/60/60/24/30) }} m</small></a>
                         @break
                     @default
                          <a href="#" title="{{ date('D j F Y',strtotime($comment->created_at)) }}"><small>{{  round($time/60/60/24/365) }} y</small></a>
                 @endswitch
                 
                   
                 
                   
                    <?php $data_comment++ ?>

                 
                </span>
                @if (isset(auth::user()->id))
                  
              
                @if ($post->UserId->id === auth::user()->id || $comment->UserId->id === auth::user()->id)
                  
                
                <div class="dropdown">

                 <div class="fa fa-ellipsis-h ellipsis" id="dropdown-edit-delete-comment" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></div>
                 <div class="Edit-comment update-comment">
                  <input type="hidden" class='comment_id' value="{{ $comment->id }}">
                  <textarea class='form-control comment-edit'>{!! $comment->comments !!}</textarea>
                  <input type="button" value="Save" class="btn btn-primary btn-sm save">
                  <input type="button" value="Cancel" class="btn btn-sm cancel">
                </div>
                  <div class="dropdown-menu dropdown-menu-comment" aria-labelledby="dropdown-edit-delete-comment">
                        <input type="hidden" class='comment_id' value="{{ $comment->id }}">
                        @if ($comment->UserId->id === auth::user()->id)
                            <a class="dropdown-item dropdown-item-comment dropdown-item-comment-edit" href="#" >Edit</a>
                        @endif
                      
                        <a class="dropdown-item dropdown-item-comment dropdown-item-comment-delete" href="#">Delete</a>
                       
                  </div>

                </div>
                @endif
          {{-- start like comment --}}
              <div class="likeComment">
                  <span class="d-none comment_id">{{ $comment->id }}</span>
                 
                      @php
                        $like_comment = \App\Like_comment::where(['user_id'=>auth()->user()->id,'comment_id'=>$comment->id])->get();
                      @endphp

                  @if ($like_comment->toArray() == null)
                      <button type="button" class='btn_like_comment'>Like</button>
                   @else
                       @foreach ($like_comment as $likeComment)

                            @if ($likeComment->status == 'like')
                              <button type="button" class='btn_like_comment' style="color:red">Like</button>
                            @endif
                      @endforeach 
                  @endif

                   @if ( count($comment->CommentLike) > 0)
                     <a href="#" data-toggle="modal" data-target="#{{ md5($comment->id) }}" class="showLikeComment"><i class="fa fa-thumbs-up"></i><span>{{ count($comment->CommentLike) }}</span></a>
                     @include('posts.showLikeComment')
                   @endif
    
                 <a href="#" class="Reply">Reply</a>
               </div>
       {{-- End like comment --}}
             @endif
         
             @include('posts.like_Reply_Comment')

             @if (count($comment->Comment_reply)>0 && isset(auth::user()->id))
                <div class="more-reply">
                 <a href="#" title=""> <i class="fa fa-reply" style="transform: rotateZ(180deg);"></i> {{ count($comment->Comment_reply)  }} reply</a>
                </div>
               
             @endif
             <div class="Show_Reply_Comment">
               
             </div>
            
              </div>
                
              @endif
            @endforeach 



          