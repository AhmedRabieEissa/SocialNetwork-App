<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class PostController extends Controller
{
    //

    public function getDashboard()
    {
        $post = Post::orderBy('created_at','desc')->get();

        return view('dashboard',compact('post'));
    }


    public function postCreatePost(Request $request)
    {
        $this->validate($request,[
            'body'=>'required|max:1000'
        ]);

        $post = new Post();
        $post-> body = $request['body'];

        $message = 'there is an error in this post';

        if($request->user()->post()->save($post))
        {
            $message = 'post created successfully';
        }

        return redirect()->route('dashboard')->with(['message'=>$message]);
    }

    public function getPostDelete($post_id)
    {
        $post = Post::where('id',$post_id)->first();
        if(Auth::User() != $post->user)
        {
            return redirect()->route('dashboard');
        }
        $post->delete();

        return redirect()->route('dashboard');
    }

    public function getLogOut()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    public function getAccount(){
        return view('account',['user'=>Auth::user()]);
    }

    public function postSaveAccount(Request $request){
        $this->validate($request,[
           'name'=>'required|max:120'
        ]);

        $user = Auth::user();
        $user->name = $request['name'];
        $user->update();
        $file = $request->file('image');
        $filename = $request['image'] . '-' . $user->id . '.jpg';
        if($file)
        {
            Storage::disk('local')->put($filename,File::get($file));
        }

        return redirect()->route('account');
    }


    public function getUserImage($filename)
    {
        $file = Storage::disk('local')->get($filename);
        return new Response($file,200);
    }
}
