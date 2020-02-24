

           <!-- Modal -->
              <div class="modal fade" id="{{ md5($comment->id) }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">People</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <p aria-hidden="true">&times;</p>
                      </button>
                    </div>
                    <div class="modal-body">
                     
                      @php
                        $like_comment = \App\Like_comment::where(['comment_id'=>$comment->id])->get();
                       
                      @endphp


                     @foreach ($like_comment as $like)
                        <p>
                            <a href="{{ url('users/'.$like->User_id->username) }}" >{{ $like->User_id->username }}</a>

                        </p>    
                      @endforeach
                      
                    </div>
   
                  </div>
                </div>
              </div>