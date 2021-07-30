@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Upload Foto</div>

                <div class="card-body">
                    <form method="POST" action="/post" enctype="multipart/form-data">
                        @csrf
                        
                        <x-fileupload name="image" />
                        <x-textarea label="Caption" name="caption" />
                        <div class="text-center my-2">
                            <img id="previewImg" src="" alt="" height="150" width="150"/>
                        </div>  
    
                        <x-submitbtn label="Post!" />

                        <script>
                            function preview() {
                                document.getElementById('previewImg').src = URL.createObjectURL(event.target.files[0])
                            }
                        </script>
                    </form>
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
