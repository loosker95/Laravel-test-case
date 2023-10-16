<?php

namespace App\Http\Controllers;

use App\Events\CreatePostEvent;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Factories\Factory;



class MainController extends Controller
{
    public function index(){
        return view('index');
    }

    public function list(){
        $data = Post::with('user')->orderByDesc('id')->paginate(10);
        return view('dashboard')->with('posts',$data);
    }

    public function create(){
        return view('pages.create');
    }

    public function store(PostRequest $request){
        $data = Post::create([
            'user_id' => User::inRandomOrder()->first()->id,
            'summary' => fake()->realText(),
            'body' => fake()->realText($minNbChars = 1000, $indexSize = 2),
        ] + $request->validated());

        event(new CreatePostEvent($data));

        return back()->with('success', 'Post submit succesfully');
    }

    public function show($id){
        $data = Post::with('user')->find($id);
        if(!$data){
            return abort(404);
        }

        return view('pages.show')->with('post', $data);
    }

    public function edit($id){
        $data = Post::find($id);
        if(!$data){
            return abort(404);
        }
        if (!Gate::allows('can-edit')) {
            abort(403);
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
