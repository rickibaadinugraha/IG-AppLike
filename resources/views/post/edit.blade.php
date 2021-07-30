@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Caption</div>

                <div class="card-body">
                    <form method="POST" action="/post/{{$post->id}}" >
                        @csrf
                        @method('PUT')
                        
                    <img src="{{asset('images/posts/' . $post->image)}}" alt="{{$post->caption}}" height="200" width="200" />
                    <x-textarea label="Caption" name="caption" :object="$post" />

                    <x-submitbtn label="Update Post!" />
                    </form>
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
