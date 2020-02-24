

         <div class="d-none write_reply">
           @if (isset(auth::user()->username))
          <form class="replyForm" method="get" accept-charset="utf-8"> 
            <input type="hidden" class="comment" value="{{ $comment->id }}">
             <textarea name="comment" class="form-control LikeComment" placeholder="Wirte a comment"></textarea>
          </form> 
          @endif
        </div>