<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\Post;
use App\Http\Resources\Post as PostResource;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function loadmore($time)
    {
        $user = Auth::user();

        // id from following and current login user
        $id_list = $user->following()->pluck('follows.following_id')->toArray();
        $id_list[] = $user->id;

        $posts = Post::with('user', 'likes')->withCount('likes')
                        ->whereIn('user_id', $id_list)->orderBy('created_at', 'desc')
                        ->where('created_at', '<', Carbon::parse((int)$time))
                        ->take(3)->get();

        return['post' => PostResource::collection($posts)];
    }

    public function index()
    {
        $user = Auth::user();

        // id from following and current login user
        $id_list = $user->following()->pluck('follows.following_id')->toArray();
        $id_list[] = $user->id;

        $posts = Post::with('user', 'likes')->withCount('likes')
                        ->whereIn('user_id', $id_list)->orderBy('created_at', 'desc')
                        ->take(3)->get();
        return view('home', compact('posts'));
    }

    public function search(Request $request)
    {
        $querySearch = $request->input('query');
        $posts = Post::with('user', 'likes')->withCount('likes')
                        ->where('caption', 'like', '%' . $querySearch . '%')->orderBy('created_at', 'desc')
                        ->take(3)->get();
        return view('home', compact('posts', 'querySearch'));
    }
}
