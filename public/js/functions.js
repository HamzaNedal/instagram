function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

function sendData(body,url,urlImage){
    let token =$('meta[name="csrf-token"]').attr('content');
    let receiver_id =$('meta[name="receiver_id"]').attr('content');
    let image =  $('#image')[0].files[0];
    var form_data = new FormData();
    form_data.append('image',image);
    form_data.append('receiver_id',receiver_id);
    form_data.append('body',body);

    if (body.replace(/\s/g, '').length || image !='undefined') {
        body = htmlEntities(body);
        $.ajax({
        type: "Post",
        url: url,
        data: form_data,
        processData: false,
        contentType: false,
        headers: {
                'X-CSRF-TOKEN': token
        },
        dataType: "html",
        success: function (response) {
             response = JSON.parse(response);

            if (!response.error) {
                if(body==''&&response.image_name!=null){
                    $(`#messageShowInline-${receiver_id}`).text(`Sent photo`);
                    $('.msg_history').append(`
                    <div class="outgoing_msg" id='message-${response.message_id}'>
                        <div class="sent_msg">
                               <div style="background-image:url(${urlImage}/${response.image_name})" class="imgStyle"></div>
                                <span class="time_date"> ${response.updated_at}</span>
                         </div>
                         <div>
                            <input type="hidden" name="message_id" class="message_id" value="${response.message_id}">
                            <input type="hidden" name="_method" value="delete">
                            <button class="float-right btn btn-link delete_message">x</button>
                        </div>
                    </div>

                  `)

                }else if(body!=''&&response.image_name!=null){
                    $(`#messageShowInline-${receiver_id}`).text(`${body}`);
                    $('.msg_history').append(`

                    <div class="outgoing_msg" id='message-${response.message_id}'>
                        <div class="sent_msg">
                            <div style="background-image:url(${urlImage}/${response.image_name})" class="imgStyle"></div>
                                <p>${body}</p>
                                <span class="time_date"> ${response.updated_at}</span>
                        </div>
                        <div>
                            <input type="hidden" name="message_id" class="message_id" value="${response.message_id}">
                            <input type="hidden" name="_method" value="delete">
                            <button class="float-right btn btn-link delete_message">x</button>
                        </div>
                    </div>

                    `)
                }else{
                    $(`#messageShowInline-${receiver_id}`).text(`${body}`);
                    $('.msg_history').append(`
                    <div class="outgoing_msg" id='message-${response.message_id}'>
                            <div class="sent_msg">
                                <p>${body}</p>
                                <span class="time_date"> ${response.updated_at}</span>
                            </div>
                            <div>
                                <input type="hidden" name="message_id" class="message_id" value="${response.message_id}">
                                <input type="hidden" name="_method" value="delete">
                                <button class="float-right btn btn-link delete_message">x</button>
                            </div>
                    </div>
                    `)
                }
                $('#image').val(null);
                $('.img').empty();
                $("#data-message")[0].emojioneArea.setText(" ");
                $('#chat').animate({scrollTop: $('#chat').prop("scrollHeight")}, 500);
            }
        }
    });


    }
}
function uploadForm(idForm){
    $(`${idForm}`).ajaxForm({

        beforeSend:function(){
            $('#success').empty();
        },
        uploadProgress:function(event, position, total, percentComplete)
        {

            $('.progress-bar').text(percentComplete + '%');
            $('.progress-bar').css('width', percentComplete/16 + '%');
        },
        success:function(data)
        {
            obj = JSON.parse(data);
            // console.log(data.message);
            if(obj.message != 'success')
            {
                $('.progress-bar').text('0%');
                $('.progress-bar').css('width', '0%');
                // $('#success').html('<span class="text-danger"><b>'+data.errors+'</b></span>');
            }
            if(obj.message == 'success')
            {
                $('.progress-bar').text('Uploaded');
                $('.progress-bar').css('width', '6.5%');
                // $('#success').html('<span class="text-success"><b>'+data.success+'</b></span><br /><br />');
                // $('#success').append(data.image);
            }
        }
    });
}

function PreviewImage(obj,destination){

    let imgItem = obj[0].files;
    let imgCount = obj[0].files.length;
    let imgPath = obj[0].value;
    let imgExt= imgPath.substring(imgPath.lastIndexOf('.')+1).toLowerCase();
    let imgPreview= $(`${destination}`);
    imgPreview.empty();
    if (imgExt =='gif' || imgExt =='jpg' || imgExt =='png' || imgExt =='jpeg'|| imgExt =='bmp') {

      if (typeof(FileReader) !='undefined' ) {

        for (let i = 0; i < imgCount; i++) {

          let reader = new FileReader();
          let fn = imgItem[i].name;
          let fs = imgItem[i].size;
          let ft = imgItem[i].type;

          reader.onload = function(e){
            $('<img />',{
              'src':e.target.result,
              'width':"50px",
              'height':"50px",
              'title':fn+" and size "+fs+" bytes and type "+ft,
              'alt':fn+" and size "+fs+" bytes and type "+ft,
            }).appendTo(imgPreview);

          }
            reader.readAsDataURL(obj[0].files[i]);
        }
        $(`${destination}`).append(`<div class="progress-bar" role="progressbar" aria-valuenow=""
                  aria-valuemin="0" aria-valuemax="100" style="width: 0%;height: 21%;font-size: 7px;">
                    0%
                  </div>`);
      }else{
        imgPreview.html('Nothing');
      }
    }else{
      imgPreview.html('Pleace enter just image');
    }
}

function showMessageReceived(responce,imageUrlAsset,imageUrl){
    if((responce.body==null || responce.body=="")&&responce.image!=null){
       $(`#messageShowInline-${responce.sender_id}`).text(`Sent photo`);
        $('.msg_history').append(`<div class="incoming_msg" id='message-${responce.id}'>
                                        <div class="incoming_msg_img"> <img style="border-radius: 45px;width: 40px;height: 40px;" src="${imageUrl}" alt="sunil"> </div>
                                        <div class="received_msg">
                                            <div class="received_withd_msg">
                                                <div style="background-image:url(${imageUrlAsset}/${responce.image})" class="imgStyle "></div>
                                                <span class="time_date"> ${responce.updated_at}</span>
                                        </div>
                                    </div>`)

    }else if((responce.body!=null || responce.body!="")&&responce.image!=null){
       $(`#messageShowInline-${responce.sender_id}`).text(`${responce.body}`);
        $('.msg_history').append(`<div class="incoming_msg" id='message-${responce.id}'>
                                        <div class="incoming_msg_img"> <img style="border-radius: 45px;width: 40px;height: 40px;" src="${imageUrl}" alt="sunil"> </div>
                                        <div class="received_msg">
                                            <div class="received_withd_msg">
                                            <p>${responce.body}</p>
                                            <div style="background-image:url(${imageUrlAsset}/${responce.image})" class="imgStyle "></div>
                                            <span class="time_date"> ${responce.updated_at}</span>
                                        </div>
                                    </div>`)
    }else{
       $(`#messageShowInline-${responce.sender_id}`).text(`${responce.body}`);
        $('.msg_history').append(`<div class="incoming_msg" id='message-${responce.id}'>
                                        <div class="incoming_msg_img"> <img style="border-radius: 45px;width: 40px;height: 40px;" src="${imageUrl}" alt="sunil"> </div>
                                        <div class="received_msg">
                                            <div class="received_withd_msg">
                                            <p>${responce.body}</p>
                                            <span class="time_date"> ${responce.updated_at}</span>
                                        </div>
                                    </div>`)
    }
}

function showMessageSender(responce,imageUrlAsset){
    console.log(responce.body);
    if((responce.body==null || responce.body=="") && responce.image!=null){

        $(`#messageShowInline-${responce.receiver_id}`).text(`Sent photo`);
        $('.msg_history').append(`<div class="outgoing_msg" id='message-${responce.id}'>
                                    <div class="sent_msg">
                                        <div style="background-image:url(${imageUrlAsset}/${responce.image})" class="imgStyle radiusBRight"></div>
                                        <span class="time_date"> ${responce.updated_at}</span>
                                    </div>
                                    <div>
                                        <input type="hidden" name="message_id" class="message_id" value="${responce.id}">
                                        <input type="hidden" name="_method" value="delete">
                                        <button class="float-right btn btn-link delete_message">x</button>
                                    </div>
                                </div>`)

    }else if((responce.body!=null || responce.body!="") && responce.image!=null){
        $(`#messageShowInline-${responce.receiver_id}`).text(`${responce.body}`);
                    $('.msg_history').append(`<div class="outgoing_msg" id='message-${responce.id}'>
                                                <div class="sent_msg">
                                                    <p>${responce.body}</p>
                                                    <div style="background-image:url(${imageUrlAsset}/${responce.image})" class="imgStyle radiusBRight"></div>
                                                    <span class="time_date"> ${responce.updated_at}</span>
                                                </div>
                                                <div>
                                                    <input type="hidden" name="message_id" class="message_id" value="${responce.id}">
                                                    <input type="hidden" name="_method" value="delete">
                                                    <button class="float-right btn btn-link delete_message">x</button>
                                                </div>
                                            </div>`)
    }else{
        $(`#messageShowInline-${responce.receiver_id}`).text(`${responce.body}`);
            $('.msg_history').append(` <div class="outgoing_msg" id='message-${responce.id}'>
                                            <div class="sent_msg">
                                                <p>${responce.body}</p>
                                                <span class="time_date"> ${responce.updated_at}</span>
                                            </div>
                                            <div>
                                                <input type="hidden" name="message_id" class="message_id" value="${responce.id}">
                                                <input type="hidden" name="_method" value="delete">
                                                <button class="float-right btn btn-link delete_message">x</button>
                                            </div>
                                        </div>`)
    }
}

function typingg(roomShared1){

    function typing(){
        if($('.emojionearea-editor').length !==0){
            $('.emojionearea-editor')[0].addEventListener("keydown", function(e){
                console.log(roomShared1);
                typing = true;
                if($('.emojionearea-editor')[0].innerHTML.length == 0){
                    typing = false;
                }
                let channel = window.Echo.private(`typing-${roomShared1}`)
                setTimeout( () => {
                channel.whisper('typing',{
                    typing:typing
                })
                }, 300)
            })
        }
    }
    typing();
        window.Echo.private(`typing-${roomShared1}`)
        .listenForWhisper('typing', (e) => {
            if(e.typing){
                // console.log(roomShared1);
                // console.log($(`#typing-${roomShared1}`));
            //  $('#messageShowInline').text(`typing...`);
              $(`#typing-${roomShared1}`).removeClass('d-none');
            }else{
            //  $('#messageShowInline').text(``);
              $(`#typing-${roomShared1}`).addClass('d-none');
            }
        });

}

