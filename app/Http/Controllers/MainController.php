<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;


class MainController extends Controller
{
    public function index(){

        $data = Post::with('user')->orderByDesc('id')->paginate(10);
        return view('dashboard')->with('posts',$data);
    }

    public function create(){
        return view('pages.create');
    }

    public function store(PostRequest $request){

        $data = Post::create([
            'user_id' => User::InRandomOrder()->first()->id,
            'title' => $request->title,
            'summary' => $request->summary,
            'body' => $request->body,
        ]);

        return back()->with('success', 'Post submit succesfully');
    }

    public function edit($id){
        $data = Post::find($id);
        if(!$data){
            return abort(404);
        }
        return view('pages.edit')->with('post', $data);
    }

    public function update(PostRequest $request, $id){

        $data = Post::find($id);
        $currentData =['title' => $data['title'], 'summary' => $data['summary'], 'body' => $data['body']];
        $updateData =['title' => $request->title, 'summary' => $request->summary, 'body' => $request->body];

        if (!array_diff($currentData, $updateData)) {
            return back()->with('error', 'No fields has been updated :( ');
        }

        Post::where('id', $id)->update($updateData); 
        return back()->with('success', 'Post updated succesfully');
    }

    public function destroy($id){
        Post::where('id', $id)->delete();
        return back()->with('success', 'Post deleted succesfully');

    }
}
