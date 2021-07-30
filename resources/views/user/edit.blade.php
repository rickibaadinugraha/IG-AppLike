@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> Update profile {{$user->username}} </div>

                <div class="card-body">
                    <form method="POST" action="/user/edit" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <x-input label="Username" name="username" :object="$user" />
                        <x-input label="Fullname" name="fullname" :object="$user" />
                        <x-input label="Biodata" name="bio" :object="$user" />
                        <x-fileupload name="avatar" />

                        <x-submitbtn label="Update profile" />
                    </form>
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
