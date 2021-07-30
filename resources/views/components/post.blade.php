<div>
    <p>
        <x-avatar :user="$post->user" size="32" />
        <a href="/{{'@'.$post->user->username}}">{{'@'.$post->user->username}}</a>
    </p>

    <img src="{{asset('images/posts/' . $post->image)}}" alt="{{$post->caption}}" 
    height="auto" width="100%" ondblclick="like({{$post->id}})" />

        <p class="mb-0">                  
            <span class="captions"> {{$post->caption}} </span>
        </p>

        <p>
            <small>
                {{ $post->created_at->diffForHumans() }}
            </small>
        </p> 

            <span class="total_count" id="post-likescount-{{ $post->id }}"> {{ $post->likes_count }} </span>

            <a class="text-dark" onclick="like({{$post->id}})" id="post-btn-{{$post->id}}">
                {{ ($post->is_liked() ? 'unlike' : 'like' ) }}
            </a>

            @isset($isShow)
            @else
            <a class="text-dark" href="/post/{{$post->id}}">Comment</a><br>
            @endisset
</div>