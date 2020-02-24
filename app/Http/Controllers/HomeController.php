<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photo;
use App\Posts;
use App\Comments;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //  $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //  $posts    = Posts::orderBy('created_at', 'desc')->whereNotIn('id',[19,20,18])->get();
        $posts    = Posts::orderBy('created_at', 'desc')->limit(2)->get();
        // $s = Posts::find([$posts[0]->id,$posts[1]->id]);
        //  dd($posts);
        $photos   = Photo::get();
        $comments = Comments::get();
        return view('home')->with(compact('posts', 'photos', 'comments'));
    }
}
