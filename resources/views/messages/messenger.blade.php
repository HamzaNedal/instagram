@extends('layouts.app')
@section('content')
<html>

@push('css')
<meta name="receiver_id" content="" >
<meta name="sender_id" content="" >
<link href="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.1/emojionearea.min.css" rel="stylesheet" type="text/css" />
@endpush
<head>
    <style>
        #clickToChoosePhoto {
    font-size: 20px;
    color: #3f3f48;
    margin-right: 22px;
    margin-top: 2px;
    text-decoration: none;
}
    .container{max-width:1170px; margin:auto;}
img{ max-width:100%;}
.inbox_people {
  background: #f8f8f8 none repeat scroll 0 0;
  float: left;
  overflow: hidden;
  width: 40%; border-right:1px solid #c4c4c4;
}
.inbox_msg {
  border: 1px solid #c4c4c4;
  clear: both;
  overflow: hidden;
}
.top_spac{ margin: 20px 0 0;}


.recent_heading {float: left; width:40%;}
.srch_bar {
  display: inline-block;
  text-align: right;
  width: 60%; padding:
}
.headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

.recent_heading h4 {
  color: #05728f;
  font-size: 21px;
  margin: auto;
}
.srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;}
.srch_bar .input-group-addon button {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  padding: 0;
  color: #707070;
  font-size: 18px;
}
.srch_bar .input-group-addon { margin: 0 0 0 -27px;}

.chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
.chat_ib h5 span{ font-size:13px; float:right;}
.chat_ib p{ font-size:14px; color:#989898; margin:auto}
.chat_img {
  float: left;
  width: 11%;
}
.chat_ib {
  float: left;
  padding: 0 0 0 15px;
  width: 88%;
}

.chat_people{ overflow:hidden; clear:both;}
.chat_list {
  border-bottom: 1px solid #c4c4c4;
  margin: 0;
  padding: 18px 16px 10px;
  cursor: pointer;
}
.inbox_chat { height: 550px; overflow-y: scroll;}

.active_chat{ background:#ebebeb;}

.incoming_msg_img {
  display: inline-block;
  width: 6%;
}
.received_msg {
  display: inline-block;
  padding: 0 0 0 10px;
  vertical-align: top;
  width: 92%;
 }
 .received_withd_msg p {
  background: #ebebeb none repeat scroll 0 0;
  border-radius: 3px;
  color: #646464;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
}
.time_date {
  color: #747474;
  display: block;
  font-size: 12px;
  margin: 8px 0 0;
}
.received_withd_msg { width: 57%;}
.mesgs {
  float: left;
  padding: 30px 15px 0 25px;
  width: 60%;
  margin-top: 25px;
}

 .sent_msg p {
  background: #05728f none repeat scroll 0 0;
  border-radius: 3px;
  font-size: 14px;
  margin: 0; color:#fff;
  padding: 5px 10px 5px 12px;
  width:100%;
}
.outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
.sent_msg {
  float: right;
  width: 46%;
  overflow-wrap: break-word;

}
.input_msg_write input {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  color: #4c4c4c;
  font-size: 15px;
  min-height: 48px;
  width: 100%;
}

.type_msg {border-top: 1px solid #c4c4c4;position: relative;}
.msg_send_btn {
  background: #05728f none repeat scroll 0 0;
  border: medium none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  right: 3px;
    top: 79px;
  width: 33px;
}
.messaging { padding: 0 0 50px 0;}
.msg_history {
  height: 516px;
  overflow-y: auto;
}

.imgStyle{
        background-size: cover;
        width: 113px;
        height: 156px;
        border-radius: inherit;
        background-position: center center;
        border-bottom-right-radius: 25px;
        border-top-right-radius: 25px;
        border-top-left-radius: 25px;
        background-color: #c4c4c4;
        margin-bottom: 5px
    }
    .radiusBLeft{
        border-bottom-left-radius: 4px !important;
        border-bottom-right-radius: 25px !important;
    }
    .radiusBRight{
        border-bottom-right-radius: 4px !important;
        border-bottom-left-radius: 25px !important;
    }
    </style>
</head>
<body>
<div class="container">
    @if (isset($id))
        <div class="userInfo" style="
        position: relative;
        left: 41%;
        width: 59%;
        height: 50px;
        top: 66px;
        margin-bottom: 13px;
        border-bottom: 1px solid #bebebe;">
                <div class="chat_img">
                    <img style="border-radius: 45px;width: 40px;height: 40px;" src="{{ asset('profile/'.$user->photo) }}" alt="sunil">
                </div>
                     <div class="chat_ib" style="margin-left: -37px;">

                         <h5 style="line-height: 42px;font-weight: bold;"><a href="{{ url('users/'.$user->username) }}">{{  $user->username  }}</a> </h5>

                    </div>

        </div>
    @endif

<div class="messaging">
      <div class="inbox_msg">
        <div class="inbox_people">
          <div class="headind_srch">
            <div class="recent_heading">
              <h4>Recent</h4>
            </div>
            <div class="srch_bar">
              <div class="stylish-input-group">
                <input type="text" class="search-bar"  placeholder="Search" >
                <span class="input-group-addon">
                <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                </span> </div>
            </div>
          </div>

          <div class="inbox_chat">
            @foreach ($users as $user)
                @if ($user->lastMessage)
                    <div class="chat_list">
                        <input type="hidden" class="id" value="{{$user->user->id}}">
                        <div class="chat_people">
                            <div class="chat_img"> <img style="border-radius: 45px;width: 40px;height: 40px;" src="{{  $user->user->id == auth()->user()->id ? asset('defaultImage/savedmessages.jpg') : asset('profile/'.$user->user->photo) }}" alt="sunil"> </div>
                            <div class="chat_ib">

                            <h5>{{ $user->user->id == auth()->user()->id ? 'Saved Messages' : $user->user->username  }} <span class="chat_date">{{ $user->lastMessage->updated_at }}</span></h5>
                            <p id="messageShowInline-{{$user->user->id}}">
                                @if ($user->lastMessage->body == null)
                                        Sent photo
                                    @else
                                    {{ html_entity_decode($user->lastMessage->body) }}
                                @endif
                            </p>
                            </div>
                        </div>
                        </div>

                    @else

                    <div class="chat_list">
                        <input type="hidden" class="id" value="{{$user->user->id}}">
                        <div class="chat_people">
                            <div class="chat_img"> <img style="border-radius: 45px;width: 40px;height: 40px;" src="{{  $user->user->id == auth()->user()->id ? asset('defaultImage/savedmessages.jpg') : asset('profile/'.$user->user->photo) }}" alt="sunil"> </div>
                            <div class="chat_ib">
                            <h5>{{ $user->user->id == auth()->user()->id ? 'Saved Messages' : $user->user->username  }}</h5>
                            </div>
                        </div>
                        </div>
                @endif

            @endforeach
          </div>


        </div>
        <div class="mesgs">
          <div class="msg_history">
          </div>
        <span id="typing" class="d-none typing">typing...</span>
          <div class="type_msg">
            <div class="input_msg_write">

                <form method="post" action="{{ route('upload') }}" enctype="multipart/form-data" id="upload-image">
                    @csrf
                    <input type="file" name = "image" id="image" class="d-none">
                    <input type="submit" id='uploadAjaxSubmit' name="upload" value="Upload" class="d-none" />

                </form>

                    <textarea name="" class="write_msg" id="data-message" cols="30" rows="10"></textarea>

              <button class="msg_send_btn" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
            </div>
          </div>
        </div>
      </div>


    </div></div>
    </body>
    @push('jsforpage')
    <script src="{{ asset('js/emojioneArea.min.js') }}" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.textcomplete/1.8.5/jquery.textcomplete.min.js"></script>
    <script src="{{ asset('js/functions.js') }}"></script>

    <script>

   var roomShared = '';
        $(document).ready(function () {
            $('meta[name="sender_id"]').attr('content',{{ auth()->user()->id }});
            $('meta[name="receiver_id"]').attr('content', {{ $id = isset($id) ? $id : null }} );
            for (let i = 0; i < $('.chat_list').length; i++) {

               if ($('.chat_list')[i].childNodes[1].value == {{ $id = isset($id) ? $id : 0 }}) {
                    $('.chat_list')[i].click();
               }
            }
            // $('.typing').attr('id', "typing-{{ $id }}");
        });


        $('.chat_list').unbind().bind('click',function(){
            if (!$(`.typing`).hasClass('d-none')) {
                $(`.typing`).addClass('d-none')
            }
            let id = $(this).children('.id').val();

            $('meta[name="sender_id"]').attr('content',{{ auth()->user()->id }});
            $('meta[name="receiver_id"]').attr('content',id);
            sender_id   =  $('meta[name="sender_id"]').attr('content');
            receiver_id =  $('meta[name="receiver_id"]').attr('content');

                if(sender_id>receiver_id){
                     roomShared = sender_id+""+receiver_id;
                }else{
                     roomShared = receiver_id+""+sender_id;
                }

                $('.typing').attr('id', `typing-${roomShared}`);

                function typing(){
                    if($('.emojionearea-editor').length !==0){
                        $('.emojionearea-editor')[0].addEventListener("keydown", function(e){
                            // console.log(roomShared);
                            typing = true;
                            if($('.emojionearea-editor')[0].innerHTML.length == 0){
                                typing = false;
                            }
                            let channel = window.Echo.private(`typing-${roomShared}`)
                            setTimeout( () => {
                            channel.whisper('typing',{
                                typing:typing,
                                rS:roomShared,
                                sender:sender_id,
                            })
                            }, 300)
                        })
                    }
                }
                typing();

                window.Echo.leave(`typing-${roomShared}`);
                window.Echo.private(`typing-${roomShared}`)
                .listenForWhisper('typing', (e) => {
                    if(e.typing){
                         $(`#typing-${e.rS}`).removeClass('d-none');
                         $(`#messageShowInline-${e.sender}`).text('typing....');
                    }else{
                        $(`#messageShowInline-${e.sender}`).text('');
                         $(`#typing-${e.rS}`).addClass('d-none');
                    }
                });


             var imgUrl = $(this).children('.chat_people').children('.chat_img').children('img')[0].getAttribute('src');

            $('.chat_list').removeClass('active_chat');
            $(this).addClass('active_chat');

            $.ajax({
                url:`{{url('messages/ChatUser/${id}')}}`,
                type: 'get',
                dataType: "json",
                data: {
                    "id": id,
                },
                success: function (response)
                {

                    $('.msg_history').empty();
                     let imgShow = response[1].photo;
                     let username = response[1].username;
                    $('.userInfo').children('.chat_img').children('img').attr("src",`{{asset('profile/')}}/${imgShow}`);
                    $('.userInfo').children('.chat_ib').children('h5').html(`<a href="{{ url('/users/') }}/${username}">${username}</a>`)
                    for (let i = 0; i < Object.keys(response[0]).length; i++) {

                        if(response[0][i].sender_id == {{ auth()->user()->id }}){
                            showMessageSender(response[0][i],"{{asset('/images') }}");
                        }else{
                            showMessageReceived(response[0][i],"{{asset('/images') }}",imgUrl);
                        }

                    }

                }
            });

        window.history.pushState('',"",`{{url('messages/ChatUser/${id}')}}`);
        window.Echo.leave(`laravel_database_chat-real.${sender_id}${receiver_id}`);
        window.Echo.channel(`laravel_database_chat-real.${sender_id}${receiver_id}`)
            .listen('MessageDelivered', (e) => {
                if(e.delete == 1 ){
                    $('#message-'+e.message.id).remove();
                }else{
                        if (e.message.sender_id == receiver_id) {
                            showMessageReceived(e.message,"{{asset('/images') }}",imgUrl);

                        }
                        $(`#messageShowInline-${e.message.sender_id}`).html(`<b style='color:black'>${e.message.body}<b>`);

                    $(`#typing-${roomShared}`).addClass('d-none');
            }
        });    });



    </script>


    <script>
    var body = '';

    $(document).ready(function () {

        $(document).on('click','#send',function(){
            sendData($("#data-message")[0].emojioneArea.getText(),"{{route('messages.store')}}","{{ asset('/images/') }}");
        });

        $(document).keydown('#data-message',function(e){
            if (e.which == 13 && e.shiftKey == false) {
                e.preventDefault();
            }

        });
        $('#chat').animate({scrollTop: $('#chat').prop("scrollHeight")}, 500);


        //delete message

        $(document).on('click','.delete_message',function(){
            let id = $(this).siblings('.message_id').val();
            let remove = $(this).parent().parent();
            let token =$('meta[name="csrf-token"]').attr('content');
            $.ajax(
            {
                url:`{{url('messages/${id}')}}`,
                type: 'Post',
                dataType: "JSON",
                data: {
                    "id": id,
                    "_method": 'DELETE',
                    "_token": token,
                },
                success: function (response)
                {
                    if (!response.error) {
                        $('#message-'+id).remove();
                        $(`#messageShowInline-${receiver_id}`).text( $('#message-'+(id-1)).children('.sent_msg').children('p').val());
                        remove.remove();
                    }
                }
            });


        });

        //end delete message


        $("#data-message").emojioneArea({

            events: {
            onLoad () {
                $('.emojionearea').append(`<a href="#" class="fa fa-paperclip emojionearea-button attach" id="clickToChoosePhoto" ></a>`);
            },
            keyup: function (editor, event) {
                console.log(event.shiftKey);
                if (event.which == 13 && event.shiftKey ==false) {
                    sendData(this.getText(),"{{route('messages.store')}}","{{ asset('/images/') }}");
                }
            }
            }
        });

        $(document).on('click','#clickToChoosePhoto',function(e){
            e.preventDefault();
            document.getElementById('image').click();

        });

        $('#image').change(function() {

            uploadForm("#upload-image");
            $("#uploadAjaxSubmit").click();
            PreviewImage($(this),'.img');
        });




    });

    </script>


    @endpush
    </html>
    @endsection
