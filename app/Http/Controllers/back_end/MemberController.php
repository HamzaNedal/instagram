<?php

namespace App\Http\Controllers\back_end;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\User;
use App\Posts;
use File;
class MemberController extends Controller
{


	public function Show()
	{

		return view('back_end.members.show');
	}

     public function getUser()
    {
    	$users = User::get(['id', 'name', 'email', 'created_at', 'updated_at']);

        return Datatables::of($users)->addColumn('action', function ($user) {
                return '<a href="edit/'.$user->id.'" class="btn btn-xs btn-primary mdi mdi-account-edit"><i class="glyphicon glyphicon-edit "></i></a>'
                ."  ".	
                		'<a href="remove/'.$user->id.'" class="btn btn-xs btn-danger fas fa-trash-alt"><i class="glyphicon glyphicon-edit"></i></a>';
            })->addIndexColumn()
        	
        	->make(true);

    }


    function ShowPageAddUser(){
    	return view('back_end.members.add');
    }


    public function addUser()
    {
 
    	$request = $this->validate(request(),[

            'username' => 'required|string|max:20|min:4',
            'name'     => 'sometimes|nullable|string|max:20|min:4',
            'email'    => 'required|email',
            'subject'  => 'sometimes|nullable',
            'website'  => 'sometimes|nullable',
            'gender'   => 'required',
            'password' => 'required|min:6|max:40',
            'photo'    => 'image|mimes:png,jpg,jpeg|max:10000',
    	]);

    	
    		if (request()->file('photo')) {

    			$name = request('photo')->getClientOriginalName();
              $name = explode('.', $name);
              $extensions = end($name);
              $name = time() . '_' . rand(0,999999999).".".$extensions;

              request('photo')->move(public_path() . '/profile/', $name);
              User::create(['username'=>request('username'),'email'=>request('email'),'subject'=>request('subject'),'Gender'=>request("gender"),'password'=>bcrypt(request('password')),'website'=>request('website'),'name'=>request('name'),'photo'=>$name]);

              return back()->with('success','Member added successfully');
    		}
          
              
            
       
    	

    	return back();
    }

    public function ShowPageUpdateUser($id)
    {
        //dd(preg_match('/^[0-9]+$/', $id));
    	    $user = User::find($id);
       if ($user!=null){
           return view('back_end.members.edit',compact('user'));
       }else{
           abort(404);
       }

    } 

    public function updateUser($id)
    {

    	 $user = User::find($id);
    	if ($user == null){
            abort(404);die;
        }


     $this->validate(request(),[

            'username' => 'required|string|max:20|min:4',
            'name'     => 'sometimes|nullable|string|max:20|min:4',
            'email'    => 'required|email',
            'subject'  => 'sometimes|nullable',
            'website'  => 'sometimes|nullable',
            'gender'   => 'required',
            'password' => 'nullable|min:6|max:40',
            'photo'    => 'image|mimes:png,jpg,jpeg|max:10000',
    	]);

     		if (request()->file('photo')) {

	    		  $name = request('photo')->getClientOriginalName();
	              $name = explode('.', $name);
	              $extensions = end($name);
	              $name = time() . '_' . rand(0,999999999).".".$extensions;

	              request('photo')->move(public_path() . '/profile/', $name);
              
    		if (request("password") != null) {
    			$user->update(['username'=>request('username'),'email'=>request('email'),'subject'=>request('subject'),'Gender'=>request("gender"),'password'=>bcrypt(request('password')),'website'=>request('website'),'name'=>request('name')]);
    		}else{
    		       $user->update(['username'=>request('username'),'email'=>request('email'),'subject'=>request('subject'),'Gender'=>request("gender"),'website'=>request('website'),'name'=>request('name'),'photo'=>$name]);
    		}
	          

              return back()->with('success','Member updated successfully');
    		}

    		if (request("password") != null) {
    			$user->update(['username'=>request('username'),'email'=>request('email'),'subject'=>request('subject'),'Gender'=>request("gender"),'password'=>bcrypt(request('password')),'website'=>request('website'),'name'=>request('name')]);
    			   return back()->with('success','Member updated successfully');

    		}else{
    		       $user->update(['username'=>request('username'),'email'=>request('email'),'subject'=>request('subject'),'Gender'=>request("gender"),'website'=>request('website'),'name'=>request('name')]);
    		        return back()->with('success','Member updated successfully');

    		}
    	
          return back();
    }

  	public function deleteUser($id)
  	{

  		$user = User::find($id);
	   if(File::exists("profile/".$user->photo)) {
	        File::delete("profile/".$user->photo);
	        $user->delete();

	        return back()->with('success','Member deleted successfully');
	    }
  		
	    return back();
  	}


}