<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Notification;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle($type, $object_id)
    {
        if($type == "POST"){
            $object = Post::findOrFail($object_id);
            $post_id = $object->id;
        }else {
            $object = Comment::findOrFail($object_id);
            $post_id = $object->$post_id;
        }

        $attr = ['user_id' => Auth::user()->id];

        if($object->likes()->where($attr)->exists()){
            $object->likes()->where($attr)->delete();
            $msg = ['status' => 'UNLIKE'];

            $this->cancelNotify(Auth::user(), $post_id);

        }else{
            $object->likes()->create($attr);
            $msg = ['status' => 'LIKE'];
        }

        $this->notify(Auth::user(), $post_id);

        return response()->json($msg);
    }

    private function notify($user, $post_id)
    {
        $target_id = Post::find($post_id)->user_id;

        if($user->id != $target_id){
            Notification::create([
                'user_id' => $target_id,
                'post_id' => $post_id,
                'message' => 'Kamu mendapat likes dari ' . $user->username
            ]);
        }
    }

    private function cancelNotify($user, $post_id)
    {
        $target_id = Post::find($post_id)->user_id;

        if($user->id != $target_id){
            Notification::where('user_id', $target_id)->where('post_id', $post_id)
                        ->where('message', 'like', '%likes%')->delete();
        }
    }
}
