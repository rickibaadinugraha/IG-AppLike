@php 

    $avatar_url = ($user->avatar)
        ? asset('images/avatar/' . $user->avatar)
        : "https://ui-avatars.com/api/?size128&name=" . $user->username;
@endphp

<img src="{{$avatar_url}}" class="rounded-circle" 
    alt="Foto profil {{$user->username}}" width="{{ $size ?? 128 }}" height="{{ $size ?? 128 }}" />
