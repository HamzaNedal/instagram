<?php
namespace App\Http\Controllers;

use App\Comments;
use App\Likes;
use App\Like_comment;
use App\Photo;
use App\Posts;
use App\ReplyComment;
use App\User;
use auth;
use File;
use Illuminate\Http\Request;
use Validator;

class postController extends Controller
{
/**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */
    private function convertHashtags($str)
    {
        $regex = "/#+([a-zA-Z0-9_]+)/";
        $str   = preg_replace($regex, '<a href="hashtag.php?tag=$1">$0</a>', $str);
        return ($str);
    }
    public function index()
    {
    }
/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */
    public function create()
    {
        return view('posts.create');
    }
/**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function store(Request $request)
    {
        // dd(request('image'));
        $data = $this->validate(request(), [
            'image.*' => 'required|image',
        ]);
        if ($request->hasfile('image')) {
            $post = Posts::create(['user_id' => auth::user()->id]);
            foreach (request('image') as $value) {
              $name = $value->getClientOriginalName();
              $name = explode('.', $name);
              $extensions = end($name);

                //dd($extensions);
                $name = time() . '_' . rand(0,999999999).'.'.$extensions;
                $value->move(public_path() . '/files/', $name);
                Photo::create(['user_id' => auth::user()->id, 'post_id' => $post->id, 'photo' => $name]);
            }
        }
        return redirect()->to('/home');
    }
/**
 * Display the specified resource.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function show($id)
    {

    }
/**
 * Show the form for editing the specified resource.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function edit($id)
    {
// $photos =   Photo::where(['post_id'=>$id])->get();
        // return view('posts.edit')->with(['id'=>$id,'photos'=>$photos]);
    }
/**
 * Update the specified resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function update(Request $request, $id)
    {
//   $data = $this->validate(request(),[
        //       'image.*' => 'image'
        // ]);
        //  if($request->hasfile('image'))
        //    {
        //     foreach (request('image') as $value) {
        //          $name = $value->getClientOriginalName();
        //          $name = time().'_'.$name;
        //          $value->move(public_path().'/files/', $name);
        //          Photo::where(['user_id'=>auth::user()->id,'post_id'=>$id])->update(['photo'=>$name]);
        //     }
        //   }
    }
/**
 * Remove the specified resource from storage.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function destroy($id)
    {
        $post = Posts::find($id);
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/home');
        }
        $photos = Photo::where(['user_id' => auth::user()->id, 'post_id' => $id])->get();
        foreach ($photos as $photo) {
            File::delete("files/".$photo->photo);
        }
        Posts::find($id)->delete();
        return redirect()->to('/home');
    }
    public function like()
    {
        if (request('like') !== null && request('post_id') !== null && request('_token') !== null && request()->ajax()) {
            $data  = request()->only('like', 'post_id');
            $likes = Likes::where(['user_id' => auth::user()->id, 'post_id' => $data['post_id']])->first();
            if ($likes == null) {
                Likes::create(['status' => $data['like'], 'user_id' => auth::user()->id, 'post_id' => $data['post_id']]);
            } else {
                Likes::where(['post_id' => $data['post_id'], 'user_id' => auth::user()->id])->update(['status' => $data['like']]);
            }
            return "";
        }

    }
    public function create_Comment()
    {
        if (request()->ajax()) {
            if (request('_token') !== null && request('comment') !== null && request('post_id') !== null) {

                $data            = request()->only('comment', 'post_id');
                $data['comment'] = htmlentities($data['comment']); //Convert all applicable characters to HTML entities
                $data['comment'] = $this->convertHashtags($data['comment']);
                if ($data['comment'] !== null) {
                    Comments::create(['comments' => $data['comment'], 'user_id' => auth::user()->id, 'post_id' => $data['post_id']]);
                }
                $comment       = Comments::where(['comments' => $data['comment'], 'user_id' => auth::user()->id, 'post_id' => $data['post_id']])->first();
                $outputComment =
                "<div>"
                . "<a style='font-weight: 700;color: #0a55e4;' href='/users/" . auth::user()->username . "'>"
                . "<img  src='profile/" . auth::user()->photo . "'>"
                . "</a>"
                . "<span class='height-span'>"
                . "<a style='font-weight: 700;color: #0a55e4;' href= 'users/" . auth::user()->username . "'>" . auth::user()->name . "</a>"
                . "<p class='comment-span'>" . $comment->comments . "</p> "
                . "</span>"
                . "<div class='dropdown'>
    <div class='fas fa-ellipsis-h ellipsis' id='dropdown-edit-delete-comment' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'></div>
    <div class='Edit-comment update-comment' style='display: none;'>
      <input type='hidden' class='comment_id' value='" . $comment->id . "'>
      <textarea class='form-control comment-edit'>" . $comment->comments . "</textarea>
      <input type='button' value='Save' class='btn btn-primary btn-sm save'>
      <input type='button' value='Cancel' class='btn btn-sm cancel'>
    </div>
    <div class='dropdown-menu dropdown-menu-comment' aria-labelledby='dropdown-edit-delete-comment'>
      <input type='hidden' class='comment_id' value='" . $comment->id . "'>
      <a class='dropdown-item dropdown-item-comment dropdown-item-comment-edit' href='#' >Edit</a>
      <a class='dropdown-item dropdown-item-comment dropdown-item-comment-delete' href='#'>Delete</a>
    </div>
  </div>"
                    . "</div>";
                return json_encode($outputComment);
            } else {
                return 0;
            }

        } else {
            return redirect('/home');
        }

        return 0;

    }
    public function updateComment()
    {
        if (request()->ajax()) {

            if (request('comment_id') !== null) {
                $data = Validator::make(request()->all(), [
                    'comment_id' => 'integer|min:1',
                ]);
                if ($data->fails() !== true) {
                    $req     = request()->only('comment', 'comment_id');
                    $comment = Comments::where(['id' => $req['comment_id']])->first();

                    if ($comment->user_id === auth::user()->id) {
                        if ($comment->comments !== $req['comment']) {
                            $req['comment'] = $this->convertHashtags($req['comment']);
                            Comments::where(['id' => $req['comment_id']])->update(['comments' => $req['comment']]);
                            $comment_after_update = Comments::where(['id' => $req['comment_id']])->first();
                            return json_encode($comment_after_update->comments);
                        }
                    }
                } else {
                    return json_encode(false);
                }
            }

        } else {
            return redirect('/home');
        }
        return null;
    }
    public function deleteComment()
    {
        if (request()->ajax()) {
            if (request('comment_id') !== null) {
                $data = Validator::make(request()->all(), [
                    'comment_id' => 'integer|min:1',
                ]);
                if ($data->fails() !== true) {
                    $req = request()->only('comment_id');

                    $comment = Comments::where(['id' => $req['comment_id']])->first();
                    if ($comment !== null) {
                        $post = Posts::where(['id' => $comment->post_id])->first();
                        if ($comment->user_id === auth::user()->id || $post->user_id === auth::user()->id) {
                            Comments::where(['id' => $req['comment_id']])->delete();
                        }
                    }
                } else {
                    return json_encode(false);
                }
            } else {
                json_encode(false);
            }
        } else {
            return redirect('/home');

        }
        return;
    }
    public function likeComment()
    {
        if (request()->ajax()) {

            if (request('comment_id') !== null) {
                $data = Validator::make(request()->all(), [
                    'comment_id' => 'integer|min:1',
                ]);
                if ($data->fails() !== true) {
                    $req     = request()->only('comment_id');
                    $likes   = Like_comment::where(['user_id' => auth::user()->id, 'comment_id' => $req['comment_id']])->first();
                    $comment = Comments::find($req['comment_id']);

                    if ($likes == null) {
                        Like_comment::create(['status' => 'like', 'user_id' => auth::user()->id, 'post_id' => $comment->post_id, 'comment_id' => $req['comment_id']]);
                        return 'true';
                    } else {
                        $likes->delete();
                        return 'false';
                    }
                }
            }
        } else {
            return redirect('/home');
        }
        return;
    }

    public function replyComment()
    {
        if (request()->ajax()) {
            if (request('comment_id') !== null && request('replyComment') !== null) {
                $data = Validator::make(request()->all(), [
                    'comment_id' => 'integer|min:1',
                ]);

                if ($data->fails() !== true) {

                    $req                 = request()->only('replyComment', 'comment_id');
                    $req['replyComment'] = htmlentities($req['replyComment']); //Convert all applicable characters to HTML entities
                    $req['replyComment'] = $this->convertHashtags($req['replyComment']);
                    if ($req['replyComment'] !== null) {
                        $comment      = Comments::find($req['comment_id']);

                  $replycomment        = ReplyComment::create(['reply_comment' => $req['replyComment'], 'user_id' => auth::user()->id, 'comment_id' => $req['comment_id'], 'post_id' => $comment->post_id]);



                        $output       = '<div class="media mt-3">
                                      <a class="pr-3" href="users/"' . auth::user()->username . '">
                                          <img alt="Generic placeholder image" src="profile/' . auth::user()->photo . '">
                                          </img>
                                      </a>
                                      <div class="media-body">
                                      <h6 class="mt-0">
                                       <a href="users/"' . auth::user()->username . '" title="">'
                                        . auth::user()->name .
                                       '</a>
                                        </h6>
                                        <div class="re_comment">'
                                         .$replycomment->reply_comment.
                                        '</div></div>'.

                                     '<div class="dropdown">

                                      <div aria-expanded="false" aria-haspopup="true" class="fas fa-ellipsis-h ellipsis-reply" data-toggle="dropdown" id="dropdown-edit-delete-reply">
                                      </div>

                                      <div class="Edit-reply update-reply" style="display: none">
                                            <input class="reply_id" type="hidden" value="'. $replycomment->id .'">
                                                <textarea class="form-control reply-edit">'.$replycomment->reply_comment .'</textarea>
                                                <input class="btn btn-primary btn-sm save" type="button" value="Save">
                                                    <input class="btn btn-sm cancel" type="button" value="Cancel">
                                                    </input>
                                                </input>
                                            </input>
                                      </div>

                                        <div aria-labelledby="dropdown-edit-delete-reply" class="dropdown-menu dropdown-menu-reply ">
                                            <input class="reply_id" type="hidden" value="'. $replycomment->id .'">

                                                <a class="dropdown-item dropdown-item-reply dropdown-item-reply-edit" href="#">
                                                    Edit
                                                </a>

                                                <a class="dropdown-item dropdown-item-reply dropdown-item-reply-delete" href="#">
                                                    Delete
                                                </a>
                                            </input>
                                      </div>

                                      </div></div>';
                                      return json_encode($output);
                    }

                }
            }
        }
    }

    public function updateReply()
    {
        if (request()->ajax()) {
            if (request('reply_id') !== null && request('reply') !== null) {
                $data = Validator::make(request()->all(), [
                    'reply_id' => 'integer|min:1',
                ]);
                if ($data->fails() !== true) {
                    $req   = request()->only('reply_id', 'reply');
                    $reply = ReplyComment::find($req['reply_id']);
                    if ($reply->user_id == auth::user()->id) {
                        $req['reply'] = $this->convertHashtags($req['reply']);
                        ReplyComment::find($req['reply_id'])->update(['reply_comment' => $req['reply']]);
                        $reply2 = ReplyComment::find($req['reply_id']);
                        return json_encode($reply2->reply_comment);
                    }

                }
            }
        }
    }

    public function deleteReply()
    {
        if (request()->ajax()) {
            if (request('reply_id') !== null) {
                $data = Validator::make(request()->all(), [
                    'reply_id' => 'integer|min:1',
                ]);
                if ($data->fails() !== true) {

                    $reply = ReplyComment::find(request('reply_id'));
                    if ($reply->user_id == auth::user()->id) {
                        ReplyComment::find(request('reply_id'))->delete();
                    }

                }
            }
        }
    }

    public function Show_Reply_Comment($id)
    {

        return view('posts.Show_Reply_Comment')->with('comment_id', $id);
    }

    public function Show_Comment($id,$count)
        {   $post = Posts::find($id);
            $comments = Comments::get();
            return view('posts.showComments')->with(compact(['comments','post','count']));
        }

         public function Show_post($limit)
        {
            $count  = Posts::get();
            $count = count($count);
            $limit = (int) $limit;

         if ($limit-1 <= $count) {
            $posts  = Posts::orderBy('created_at', 'desc')->limit($limit)->get();
            $photos   = Photo::get();
            $comments = Comments::get();

                return view('posts.show_posts')->with(compact('posts','photos','comments'));

            }else{
                return json_encode('more');
            }

        }

}
