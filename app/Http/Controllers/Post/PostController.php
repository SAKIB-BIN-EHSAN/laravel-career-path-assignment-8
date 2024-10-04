<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Store a newly created resource in storage.
    */
    public function store(StorePostRequest $request)
    {
        $postData = $request->validated();

        $status = DB::table('posts')->insert([
            'user_id' => Auth::user()->id,
            'content' => $postData['post_content'],
            'created_at' => now(),
            'updated_at' => now()
        ]);

        if ($status) {
            return to_route('index');
        } else {
            return back();
        }
    }

    /**
     * Display the specified resource.
    */
    public function show(string $id)
    {
        $userInfo = Auth::user();

        $post = DB::table('posts')->where([
            'id' => $id,
            'user_id' => $userInfo->id
        ])->get();

        return view('post.view', [
            'post' => $post,
            'userInfo' => $userInfo
        ]);
    }

    /**
     * Show the form for editing the specified resource.
    */
    public function edit(string $id)
    {
        $userInfo = Auth::user();
        $post = DB::table('posts')->where('id', $id)->first();

        return view('post.edit', compact('post', 'userInfo'));
    }

    /**
     * Update the specified resource in storage.
    */
    public function update(UpdatePostRequest $request, string $id)
    {
        $validatedPost = $request->validated();

        $status = DB::table('posts')
                    ->where('id', $id)
                    ->update([
                        'content' => $validatedPost['post_content']
                    ]);
        
        if ($status) {
            return to_route('posts.show', $id);
        } else {
            return back()->withErrors([
                'post_content' => 'Can\'t update! Soemthing went wrong!'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
    */
    public function destroy(string $id)
    {
        $status = DB::table('posts')
            ->where([
                'id' => $id,
                'user_id' => Auth::user()->id
            ])
            ->delete();
        
            if ($status) {
                return back();
            }
    }
}
