<?php

namespace App\Http\Controllers;

use App\Follow;
use App\User;
use auth;
use File;
use Hash;
use Illuminate\Http\Request;
use Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show', 'search']]);
    }
    public function index()
    {
        return redirect()->to('/home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        app()->abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        app()->abort(404);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        // $x =  url()->current();
        // $x = explode('/', $x);

        $user = User::where(['username' => $username])->first();
       // dd($user, auth::user()->id);

        if ($user !== null) {
            return view('users.profile')->with('user', $user);
        }
        app()->abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        if ($user !== null && $user->id == auth::user()->id) {
            return view('users.edit')->with('user', $user);
        } else {
            app()->abort(404);
        }
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
        $data = Validator::make(request()->all(), [
            'name'     => 'required|string|max:20|min:4',
            'username' => 'required|string|max:20|min:4|unique:users,username,' . $id,
            'email'    => 'required|email|unique:users,email,' . $id,
            'subject'  => 'sometimes|nullable',
            'website'  => 'sometimes|nullable',
            'Gender'   => 'required',
        ]);
        // dd($data["name"]);
        $arr_error = [];
        if(request()->ajax()){
            if($data->fails()){
                foreach ($data->messages()->getMessages() as $filed_name => $messages) {
                    $arr_error["$filed_name"] = $messages;
                }
                $output = [
                    'error'   => $arr_error,
                    'success' => '',
                ];
                return json_encode($output);
            }else{
                $name = strip_tags(request("name"));
                 $username = strip_tags(request("username"));
                 if($name !== '' && $username !== ''){
                    User::where('id', $id)->update([
                        'name'     => $name,
                        'username' => $username,
                        'email'    => request("email"),
                        'subject'  => request("subject"),
                        'website'  => request("website"),
                        'Gender'   => request("Gender"),

                    ]);
                    $output = [
                        'error'   => '',
                        'success' => 'Updated Successfully',
                    ];
                    return json_encode($output);
                }else{
                    $output = [
                        'error'   => 'Updated Failed',
                        'success' => '',
                    ];
                }
            }


        }else{
            $name = strip_tags(request("name"));
            $username = strip_tags(request("username"));

            if($name !== '' && $username !== ''){
                User::where('id', $id)->update([
                    'name'     => $name,
                    'username' => $username,
                    'email'    => request("email"),
                    'subject'  => request("subject"),
                    'website'  => request("website"),
                    'Gender'   => request("Gender"),

                ]);
                return redirect()->to('/users/' . $id . '/edit')->with('success', 'Done');
            }else{

                return redirect()->to('/users/' . $id . '/edit');
            }
        }


        return null;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        app()->abort(404);
        //
    }

    public function follow()
    {
        if (request('user_id') !== null && request('_token')) {

        $data = Validator::make(request()->all(),[
            'user_id' => 'required|integer|min:1'
        ]);

        if ($data->fails() !== true) {
             $user = User::find(request('user_id'));

             if ( $user !== null && $user->id !== auth::user()->id) {

                    $follows = Follow::where(['followers' => auth::user()->id, 'following' => request('user_id')])->first();
                    if ($follows == null) {
                        Follow::create(['followers' => auth::user()->id, 'following' => request('user_id')]);

                        if (count($user->Notifications)==0){
                            $user->notify(new \App\Notifications\ShowNotification(["id"=>auth()->user()->id , "username"=> auth()->user()->username , "photo"=> auth()->user()->photo]));
                        }

                        return json_encode(true);
                    } else {
                        Follow::where(['followers' => auth::user()->id, 'following' => request('user_id')])->delete();
                        // dd($user->notifications());
                        $user->notifications()->delete();
                        return json_encode(true);
                    }
                }else{
                    if($user == null){
                        return json_encode('this account is not exist');
                    }elseif($user->id == auth::user()->id){
                        return json_encode('you don\'t get follow yourself');
                    }

                }
        }else{
             return json_encode('this account is not exist');
        }
    }
        return null;

    }

    public function check_email()
    {

        $data = $this->validate(request(), [
            'email' => 'required|email',
        ]);

        $user = User::where(['email' => $data['email']])->first();

        if ($user !== null && auth::user()->email !== $user->email) {
            return "false";

        } else {
            return "true";
        }
    }

    public function check_username()
    {

        $data = $this->validate(request(), [
            'username' => 'required|string',
        ]);

        $user = User::where(['username' => $data['username']])->first();

        if ($user !== null && auth::user()->username !== $user->username) {
            return "false";

        } else {
            return "true";
        }
    }



    public function update_image()
    {

        $data = $this->validate(request(), [
            'photo' => 'required|image',
        ]);

        if (request()->hasfile('photo')) {
            $user = User::where(['id' => auth::user()->id])->first();
            File::delete("profile/$user->photo");
            $name = request('photo')->getClientOriginalName();
            $name = time() . '_' . $name;

            request('photo')->move(public_path() . '/profile/', $name);
            User::where(['id' => auth::user()->id])->update(['photo' => $name]);

        }

        return redirect()->back();

    }

    public function check_password()
    {

        $data = request()->only('current_pwd');

        $user = User::where(['id' => auth::user()->id])->first();

        if (Hash::check($data['current_pwd'], $user->password)) {
            return "true";

        } else {
            return "false";
        }
    }

    public function update_pwd()
    {

        $arr_error = [];
        $success   = '';
        $data      = Validator::make(request()->all(), [
            'current_pwd' => 'required',
            'password'    => 'required',
        ], [], [
            'current_pwd' => 'Current Password',
            'password'    => 'Password',

        ]);

        if (!$data->fails()) {

            $check_password = User::Where(['id' => Auth::user()->id])->first();

            if (Hash::check(request('current_pwd'), $check_password->password)) {

                $password = bcrypt(request('password'));

                User::where(['id' => Auth::user()->id])->update(['password' => $password]);
                // return redirect()->back()->with('success_message','Password updated Successfully');
                $success = 'Password updated Successfully';
            } else {
                // return redirect()->back()->with('error_message','Incorrect Current Password!');
                $arr_error = 'Incorrect Current Password!';

            }
        } else {

            foreach ($data->messages()->getMessages() as $filed_name => $messages) {
                $arr_error[] = $messages;
            }

        }

        $output = [
            'error'   => $arr_error,
            'success' => $success,
        ];

        echo json_encode($output);

    }

    public function search()
    {
        $data = request()->only('search');
        if ($data['search'] !== null) {
            $users = User::where([

                ['name', 'LIKE', '%' . $data['search'] . '%'],

            ])->get();
            $user_Info = [];
            foreach ($users as $user) {
                $usersInfo = [
                    'name'     => $user->name,
                    'username' => $user->username,
                    'image'    => $user->photo,

                ];
                $user_Info[] = $usersInfo;
            }
            return json_encode($user_Info);
        }

        return null;
    }

    public function markRead(){
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['ReadNotifications' => "true"]);
    }

      public function getNotifications(){
        $output = '';
         foreach(auth()->user()->unreadnotifications as $notification){

              $output .= '<a class="dropdown-item" href="'. url('users/'.$notification->data['username']) .'">'.
                    '<img class="photoNote" src="'.asset('profile/'.$notification->data['photo']).'" alt="">'.
                     '<small>'.$notification->data['username'].'</small>'. '<small>Start following</small>'.
                 '</a>';
         }


        return response()->json(['notification' => $output]);
    }
}
