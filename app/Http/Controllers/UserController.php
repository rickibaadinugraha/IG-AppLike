<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($username)
    {
        $user = User::with('posts')->where('username', $username)->first(); 
        if(!$user) abort(404);

        return view('user.profile', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => 'required|alpha_dash|min:3|max:15|unique:users,username,'.$user->id,
            'fullname' => 'max:30',
            'bio'      => 'max:144'
        ]);

        $imageName = $user->avatar;
        if($request->avatar) {
            $avatar_img = $request->avatar;
            $imageName  =  $user->username . '-' . time() . '.' . $avatar_img->extension();
            $avatar_img->move(public_path('images/avatar'), $imageName);
        }

        $user->update([
            'username' => $request->username,
            'fullname' => $request->fullname,
            'bio'      => $request->bio,
            'avatar'   => $imageName,
        ]);

        return redirect('/home');
    }

    public function follow($following_id)
    {
        $user = Auth::user();

        if($user->following->contains($following_id)) {
            $user->following()->detach($following_id);
            $message = ['status' => 'UNFOLLOW'];
        }else{
            $user->following()->attach($following_id);
            $message = ['status' => 'FOLLOW'];
        }

        return response()->json($message);
    }

    public function notification()
    {
        $user = Auth::user();
        $notifs = Notification::where('user_id', $user->id)->paginate(15);

        return view('user.notification', compact('notifs'));
    }
    
    public function notificationSeen()
    {
        $user = Auth::user();
        Notification::where('user_id', $user->id)->update(['seen' => true]);

        return (['msg' => 'success']);
    }

    public function notificationCount()
    {
        $total = Auth::user()->notifications()->where('seen', 0)->count();

        return['total' => $total];
    }
}
