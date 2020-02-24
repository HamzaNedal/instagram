	@auth('web')
		
	
	@php
		$reply_comments = App\ReplyComment::where(['comment_id' => $comment_id])->get();
	@endphp

	@foreach ($reply_comments as $reply_comment)
<div class="media mt-3">
    <a class="pr-3" href="{{ url('users/'.$reply_comment->User_id->username) }}">
        <img alt="Generic placeholder image" src="{{ asset('profile/'.$reply_comment->User_id->photo) }}">
    
    </a>
    <div class="media-body">
        <h6 class="mt-0">
            <a href="{{ url('users/'.$reply_comment->User_id->username) }}" title="">
                {{ $reply_comment->User_id->name }}
            </a>
        </h6>
        <div class="re_comment">
           {!! $reply_comment->reply_comment !!}
        </div>
        <div class="data-reply">
        	 @php
                     $time = round((strtotime(now())-strtotime($reply_comment->created_at)));
                     
                    @endphp

                 @switch($time)
                     @case($time < 60)
                          <a href="#" title="{{ date('D j F Y',strtotime($reply_comment->created_at)) }}"><small>{{  $time }} sec</small></a>
                         @break
                     @case($time/60 < 60)
                          <a href="#" title="{{ date('D j F Y',strtotime($reply_comment->created_at)) }}"><small>{{  round($time/60) }} min</small></a>
                         @break
                     @case($time/60/60 <= 24)
                     @if (round($time/60/60) == 1)
                       <a href="#" title="{{ date('D j F Y',strtotime($reply_comment->created_at)) }}"><small>{{  round($time/60/60) }} hr</small></a>
                       @else
                       <a href="#" title="{{ date('D j F Y',strtotime($reply_comment->created_at)) }}"><small>{{  round($time/60/60) }} hrs</small></a>
                     @endif
                         
                         @break
                     @case($time/60/60/24 < 7)
                          <a href="#" title="{{ date('D j F Y',strtotime($reply_comment->created_at)) }}"><small>{{  round($time/60/60/24) }} d</small></a>
                         @break
                     @case($time/60/60/24/7 <= 4)
                          <a href="#" title="{{ date('D j F Y',strtotime($reply_comment->created_at)) }}"><small>{{  round($time/60/60/24/7) }} w</small></a>
                         @break 
                     @case($time/60/60/24/30 <= 12)
                          <a href="#" title="{{ date('D j F Y',strtotime($reply_comment->created_at)) }}"><small>{{  round($time/60/60/24/30) }} m</small></a>
                         @break
                     @default
                          <a href="#" title="{{ date('D j F Y',strtotime($reply_comment->created_at)) }}"><small>{{  round($time/60/60/24/365) }} y</small></a>
                 @endswitch
        </div>
    </div>

    <div class="dropdown">
        <div aria-expanded="false" aria-haspopup="true" class="fa fa-ellipsis-h ellipsis-reply" data-toggle="dropdown" id="dropdown-edit-delete-reply">
        </div>
        <div class="Edit-reply update-reply" style="display: none">
            <input class="reply_id" type="hidden" value="{{ $reply_comment->id }}">
                <textarea class="form-control reply-edit">{!! $reply_comment->reply_comment !!}</textarea>
                <input class="btn btn-primary btn-sm save" type="button" value="Save">
                    <input class="btn btn-sm cancel" type="button" value="Cancel">
                    </input>
                </input>
            </input>
        </div>
        <div aria-labelledby="dropdown-edit-delete-reply" class="dropdown-menu dropdown-menu-reply ">
            <input class="reply_id" type="hidden" value="{{ $reply_comment->id }}">
                @if ($reply_comment->user_id === auth::user()->id)
                <a class="dropdown-item dropdown-item-reply dropdown-item-reply-edit" href="#">
                    Edit
                </a>
                @endif
                <a class="dropdown-item dropdown-item-reply dropdown-item-reply-delete" href="#">
                    Delete
                </a>
            </input>
        </div>
    </div>
</div>
@endforeach
@endauth