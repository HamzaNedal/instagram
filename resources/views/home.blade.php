  @extends('layouts.app')

  @section('content')
  @push('css')
  <style>
      textarea.form-control {
         height:
}
  #like,#share{
       -webkit-appearance: initial;
        margin-left: 15px;
          background: none;
          border: none;
  }
  .card {
    border-color: white;
    border-bottom-right-radius: 33px;
    border-bottom-left-radius: 33px;
  }
  .card-header{
    background-color: white;
  }
   .btn-secondary:focus{
    -webkit-box-shadow :none;
    box-shadow :none;
   }
   .fa-ellipsis-v{
        color: black;
    background: white;
    border-color: white;
   }
  .icon{
    color:gray;
    font-size: 30px;
  }
  .icon-comment,.icon-share{
    color: gray;
    font-size: 30px;
    margin-left: 15px;
 }
.click-comment {
      position: absolute;
    margin-left: 94%;
    margin-top: 2%;
 }
 ._2dbep{
  background-color: #fafafa;
  border-radius: 50%;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  display: block;
  -webkit-box-flex: 0;
  -webkit-flex: 0 0 auto;
  -ms-flex: 0 0 auto;
  flex: 0 0 auto;
  overflow: hidden;
  position: relative;
  width: 30px;
  height: 30px;
  top: 7px;
}
.Profile_Image{
  width:100%;
  height:100%;
}
.name_profile{
  position: absolute;
  left: 70px;
  top: 21px;
}

.card-body{
  padding: 0;
}
._post{
  margin-bottom: 5px;
}
.edit-post{
      margin-top: -30px;
}
.send{
    color: gray;
    font-size: 20px;
    margin-left: 15px;
    -webkit-appearance: initial;
    position: absolute;
    top: 95%;
    left: 91%;
}
.send:hover{
  color: blue;
}
#share:hover,.icon-comment:hover{
  color:blue;

}
.date-post{
    position: absolute;
    top: 38px;
    left: 55px;
}
.like{
    color :red;
     position: absolute;
}
.unlike{
    color :gray;
     position: absolute;

}
button:focus {
  outline: none;
}
.carousel {
  width:100%;
  height: 500px;
  overflow: hidden;
}
.carousel-inner > .carousel-item > a > img {
  width:100%;
  height: 500px;
  overflow: hidden;
}
.showComments div > span {
    display: block;
    background-color: #f5f8fa;
    width: 80%;
    border-radius: 5px;
    margin-left: 8%;
    padding: 5px;
    margin-top: -30px;
    margin-bottom: 10px;
}


.showComments div > a  img{
  width: 30px;
  height: 30px;
  border-radius: 18px;
  margin-left: 6px;
}
.showComments {
  margin-top: 20px;
}

.Click_Like_comment{
    margin-top: 5px;
    border-bottom: 1px solid #f5f8fa;
    margin-left: 10px;
}
.comment-span{
  padding: 0;
    margin: 0;
    text-indent: 5px;
}
.ellipsis{
         position: absolute;
    margin-left: 84%;
    margin-top: -64.2px;
}
.dropdown-item-comment{
  padding: 1px 4px;
}
.dropdown-menu-comment{
  min-width: 4rem;
    padding: 0;
}
.keyComment{
  border-radius: 20px;
    height: 40px !important;
    text-indent: 5px;
   line-height: 27px;
    overflow: hidden;
    margin-top: 0px;
    margin-bottom: 0px;
    resize: none;
}

.likeCount{
      margin-left: 9px;
    color: red;
    font-size: 15px;
    font-weight: bold;
}
.likeComment > button{
    background: none;
    border: none;
    color: #007bff;
}
.likeComment > button:hover{
  text-decoration: underline;
}
.likeComment{
position: relative;
    margin-left: 45px;
    margin-bottom: 10px;
    margin-top: -13px;
    font-size: 11px;
}

.likeComment > a >i {
 color: #030bff;
    border-radius: 27px;
    background-color: white;
    font-size: 14px;
    position: absolute;
    margin-left: 76%;
    margin-top: -19px;
    padding: 6px;
    box-shadow: -2px 6px 13px #80808073;
    width: 8%;
    height: 27px !important;
}
.likeComment > a > span {
   margin-left: 79.5%;
    margin-top: -4.6%;
    padding: 1%;
    position: absolute;
    font-size: 15px;
    font-weight: bold;
}
.update-comment {
      margin-top: -33px;
    margin-bottom: 0px;
    resize: none;
    width: 86%;
    margin-left: 42px;
}
.update-comment > textarea{
  border-radius: 20px;
    height: 40px;
    text-indent: 5px;
    line-height: 27px;
    overflow: hidden;
    resize: none;
    margin-bottom: 6px;
}
</style>

 <style>
   .LikeComment{
     border-radius: 20px;
    height: 33px !important;
    text-indent: 5px;
    line-height: 20px;
    overflow: hidden;
    margin-top: -2%;
    margin-bottom: 0px;
    resize: none;
    width: 80%;
    margin-left: 8%;
   }
 </style>

<style>
  .show_Reply_Comment {
  display: block;
    background-color: #f5f8fa;
    width: 80%;
    border-radius: 5px;
    margin-left: 8%;
    padding: 5px;
    margin-top: -30px;
    margin-bottom: 10px;
}
.media-body {

    background-color: #f5f8fa;
    border-radius: 5px;
    text-indent: 2px;
    padding: 3px;
    width: 80%;
}
.media{
  margin-left: 4rem;
    width: 80%;
    margin-bottom: 5%;
    /* border-radius: 32px; */
    border-left: 2px solid #72cdfa;
}
.ellipsis-reply{
      margin-left: -19px;
}
.update-reply {
        margin-top: -6px;
    margin-bottom: 0px;
    resize: none;
    width: 364px;
    margin-left: -4px;
}
.update-reply > textarea{
  border-radius: 20px;
    height: 40px;
    text-indent: 5px;
    line-height: 27px;
    overflow: hidden;
    resize: none;
    margin-bottom: 6px;
}
.dropdown-item-reply{
    padding: 1px 4px
}

.dropdown-menu-reply{
  min-width: 4rem;
    padding: 0;
}
.more-reply{
      position: relative;
    left: 31%;
    top: -22px;
}
.more-comment{
       position: relative;
    left: 31%;
    top: -3px;
}
</style>

@endpush
@push('js')
<script src="{{ asset('fontawesome/js/fontawesome.js') }}"></script>
<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>

 @if (isset(auth::user()->username))
    <script>

      $(document).ready(function() {


              //Start Click Like
             $(".icon").on('click', function (){
                var like = $(this).children("input[name='like']").val();
                var _token = $(this).parent().children("input[name='_token']").val();
                var post_id = $(this).parent().children("input[name='posts']").val();
                var clickLike = $(this).parent().children("i");

                 if(clickLike.hasClass('unlike')){
                    $(this).addClass('like');
                    $(this).removeClass('unlike');

                 }else{
                    $(this).removeClass('like');
                    $(this).addClass('unlike');

                 }

                $.ajax({
                  url: '{{ url('posts/like') }}',
                  type: 'Post',
                  data: {like: like,_token:_token,post_id:post_id},
                })


              });
              // End Click Like

              //Comment Click
              var commentClass = '';
              $('.keyComment').keydown(function (e) {

                var key = e.which;

                if (e.keyCode == 27) {
                   $(this).blur();
                }

                if (key == 13 && e.shiftKey == false) {
                var comment = $(this).parent().children('textarea').val();
                var post_id = $(this).parent().children(".post").val();
                var _token  =  $(this).parent().children($('input[name="_token"]')).val();
                 commentClass =  $(this).parent().parent().parent().children('.showComments');
                var commentForm =  $(this).parent('.commentForm');


                commentForm[0].reset();
                if (comment !== ""){
                  $.ajax({
                  url: '{{ url('/posts/comment') }}',
                  type: 'post',
                  dataType: 'json',
                  data: {comment: comment,post_id : post_id,_token:_token},
                })
                .done(function(data) {

                    commentClass.append(data);


                })

                }
                $(this).blur();
              }
              });


             //start show comments
             var count = 1 ;
            $(document).on('click', '.more-comment a', function(event) {
                    event.preventDefault();
                    var post_id = $(this).siblings('.post_id').html();


                    var url_all_comments = "http://"+location.host+'/posts/Show-Comment/'+post_id+'/'+count;


                    $(this).parent().siblings('.showComments').load(url_all_comments);
                    $(this).parent().remove();
                    count++;
                  });
             //End show comments


     });</script>

@endif


<script>
  $(document).ready(function() {
    var loading = 0;
    var count_post = 4;
    var over_post = 'less';

    $(window).scroll( function() {
       var scrolled_val = $(document).scrollTop().valueOf();
        var scrollHeight = $(document).height();
         var scrollPosition = $(window).height() + $(window).scrollTop();
       if ((scrollHeight - scrollPosition) / scrollHeight == 0 && over_post == 'less') {

          var url_posts = "http://"+location.host+'/posts/Show-posts/'+count_post;

           $.ajax({
             url: '{{ url('posts/Show-posts/') }}/'+count_post,
             type: 'get',
             dataType: 'json',

           })
           .done(function(data) {
            if (data != 'more') {
               $('._shp').load(url_posts);

            }else{
               over_post='more';
            }

           })
           .fail(function() {
             $('._shp').load(url_posts);
           })
           .always(function() {
             console.log("complete");
           });

          loading++;
          count_post+=2;

       }

      });

  });

</script>


@endpush

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6 _shp">
        {{-- number of carousel And Number of comment --}}



    @include('posts.show_posts')

  </div>
</div>
</div>
@endsection
