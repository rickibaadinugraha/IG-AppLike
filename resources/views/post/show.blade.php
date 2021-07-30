@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">

                <div class="card-body">

                <x-post :post="$post" isShow="true" /> 
                <hr>

                    <form method="POST" action="/post/{{$post->id}}/comment" >
                        @csrf                        
                        <x-textarea-simple label="Your Comment" name="body" />
                        <x-submitbtn label="Post comment" />
                    </form>

                    @foreach($post->comments as $comment)
                        <p class="mb-0">
                            - <a href="/{{'@'.$comment->user->username}}">{{'@'.$comment->user->username}}</a>
                                {{$comment->body}}</p>

                            <span class="total_count" id="comment-likescount-{{ $comment->id }}">
                                {{ $comment->likes_count }} </span>

                            - <a class="text-dark" onclick="like({{$comment->id}}, 'COMMENT')" id="comment-btn-{{$comment->id}}">
                                {{ ($comment->is_liked() ? 'unlike' : 'like' ) }}
                            </a>

                            @if(Auth::user()->id == $comment->user->id)
                                - <a class="text-dark" href="/comment/{{$comment->id}}/edit">Edit</a>
                                - <a class="text-dark" onclick="event.preventDefault(); document.getElementById('delete-form').submit();">Delete</a>

                                    <form id="delete-form" action="/comment/{{$comment->id}}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                            @endif

                    @endforeach  
                </div>
            </div>
        </div>
    </div>
</div>
    
    <script src="{{asset('js/feed.js')}}"></script>
@endsection
