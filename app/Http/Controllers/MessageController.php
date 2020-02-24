<?php

namespace App\Http\Controllers;

use App\Events\MessageDelivered;
use App\Follow;
use App\Message;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use File;
class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {

        return view('messages.index');
    }
    public function messenger()
    {
        $users =  $this->getAllUsersMessage();
        //  dd($users);
        return view('messages.messenger',compact('users'));
    }
    public function chatUser($id)
    {
        $user = User::findOrFail($id);
         unset($user->email,$user->password,$user->name,$user->website,$user->subject,$user->Gender,$user->created_at,$user->updated_at,$user->id);
        if(request()->ajax()){

            return response(json_encode(
                [
                    $this->getAllMessage($id),
                    $user
                ]
            ));
        }

        $users = $this->getAllUsersMessage();
        return view('messages.messenger',compact('users','id','user'));
    }

    public function getAllMessage($id)
    {
        $messages =  DB::table('messages')
        ->where(['sender_id'=>auth()->user()->id,'receiver_id'=> $id])
        ->orWhere(function($query) use ($id)
        {
            $query->Where(['sender_id'=>$id,'receiver_id'=> auth()->user()->id]);
        })->get();

    //    $messages = $messages->sortBy('updated_at')->toArray();

        return $messages;
    }
    public function getlastMessage($receiver_id)
    {
        $messages =  DB::table('messages')
        ->where(['sender_id'=>auth()->user()->id,'receiver_id'=> $receiver_id])
        ->orWhere(function($query) use ($receiver_id)
        {
            $query->Where(['sender_id'=>$receiver_id,'receiver_id'=> auth()->user()->id]);
        })->orderByRaw('updated_at DESC')->limit(1)->get();

        return $messages;
    }

    public function getAllUsersMessage()
    {
        // $users = Message::where(function ($q) {
        //     $q->where('sender_id', auth()->user()->id)->orWhere('receiver_id', auth()->user()->id);
        // })->distinct()->get(['sender_id','receiver_id']);
    $users = Message::selectRaw('sender_id,receiver_id, IF(sender_id < receiver_id, CONCAT(sender_id,receiver_id), CONCAT(receiver_id,sender_id)) as merge')
             ->where(function ($q) {
                $q->where('sender_id', auth()->user()->id)->orWhere('receiver_id', auth()->user()->id);
             })->distinct()->get();
             $users = $users->unique('merge');
            //  dd($users);
    //   $savedMessage =  $users->contains(function ($value, $key) {
    //        if($value->sender_id == $value->receiver_id){
    //             return true;
    //        }

    //     });
        foreach ($users as  $user) {

                 if ($user->sender_id == auth()->user()->id) {
                     $user['lastMessage'] = $this->getlastMessage($user->receiver_id)->first();
                     $user['user'] = $user->getUserData;
                 }else{
                     $user['lastMessage'] = $this->getlastMessage($user->sender_id)->first();
                     $user['user'] = $user->getUserDataSender;
                 }


        }

    //     if(!$savedMessage){
    //           $user = User::where('id' ,auth()->user()->id)->first(['id','username','photo']);
    //           $user['user'] = $user;
    //           $users->prepend($user);
    //      }
   $users =  $users->sortByDesc(function ($val, $key) {
         return $val['lastMessage']->updated_at;
    });
        // dd($users);
    // dd($users);
      return  $users ;
    }

    public function store()
    {
        request()->body = preg_replace('#((https?|ftp)://(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#i',
        "'<a href=\"$1\" target=\"_blank\">$3</a>$4'",
        request()->body
      );
        User::findOrFail(request()->receiver_id);

        if (request()->body == null && request()->image == 'undefined') {
            return $this->responseState(true);
        }

        $message = Message::create([
            'sender_id'=>auth()->user()->id,
            'receiver_id'=>request()->receiver_id,
            'body'=>htmlspecialchars(request()->body),
            'image'=> session('imageName')
        ]);
        broadcast(new MessageDelivered($message))->toOthers();
        session(['imageName'=>NULL]);
        return $this->responseState(false,$message->id, $message->image,$message->updated_at);
    }

    function upload(Request $request)
    {

     $rules = [

        'image' => 'required|image|mimes:jpeg,png,jpg',
     ];
    // $validator = Validator::make(request()->all());
     $error = Validator::make($request->all(), $rules);

     if($error->fails())
     {
      return response()->json(['message' => $error->errors()->all()]);
     }

    //  $image = $request->file('file');

     $new_name = uniqid().time().'.'.request()->image->getClientOriginalExtension();
     request()->image->move(public_path().'/images/', $new_name);

     session(['imageName'=>$new_name]);

     return json_encode(['message' => 'success']);
    }

    public function destroy()
    {
        $message = Message::find(request()->id);
        if ($message) {
            broadcast(new MessageDelivered($message,1))->toOthers();
            if(File::delete("images/".$message->image)) {
                File::delete("images/".$message->image);
            }
            $messageDel = $message->delete(request()->id);
            if ($messageDel) {
               return $this->responseState();
            }else{
                return $this->responseState(true);
            }
        }

        return $this->responseState(true);

    }


    public function responseState($error = false,$id=null,$image=null,$updated_at=null)
    {
        return response(json_encode([
            'status'=>200,
            'error'=>$error,
            'message_id'=>$id,
            'image_name'=>$image,
            'updated_at'=>$updated_at
        ]));
    }
}
