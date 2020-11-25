<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() { parent::__construct(); }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('all') && app('user')->moderator) {
            $posts = Post::where('publish_date', '>=', today())->get();
            $title = 'News';
            $page  = 'moderator';
        }
        elseif ($request->has('my-posts')) {
            $posts = app('user')->posts()->where('publish_date', '>=', today())->get();
            $title = 'News';
            $page  = 'my-posts';
        }
        else {
            // TODO: filter by audience
            $posts = Post::where('publish_date', today())->get();
            $title = 'News for '. today()->format('l, M j, Y');
            $page  = 'standard';
        }

        return view('posts.index', [
            'announcements' => $posts->where('type', 'announcement'),
            'reminders'     => $posts->where('type', 'reminder'),
            'page'          => $page,
            'title'         => $title
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('posts.create', [ 'post' => new Post ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = $request->all();

        $this->validator($post)->validate();

        $post['audience'] = implode($post['audience'], ',');

        app('user')->posts()->create($post);

        return view('common.message', [
            'message' => 'Post submitted successfully.'
        ])->withType('success');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return view('posts.edit')->withPost($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $data = $request->all();

        $this->validator($data)->validate();

        $data['audience'] = implode($data['audience'], ',');

        $post->update($data);

        return view('common.message', [
            'message' => 'Post edited successfully.'
        ])->withType('success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return back();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title'        => 'required|string|min:3|max:70',
            'type'         => 'required|in:announcement,reminder',
            'audience'     => 'required|array|in:G10,G11,G12,faculty,staff',
            'publish_date' => 'required|date|after_or_equal:today',
            'body'         => 'nullable|string|min:5|max:2000'
        ]);
    }
}
