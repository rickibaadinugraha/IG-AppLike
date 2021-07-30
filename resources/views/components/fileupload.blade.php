<div class="form-group row">
    <label for="{{$name}}" class="col-md-4 col-form-label text-md-right">{{$name}}</label>
        <div class="col-md-6">
            <input type="file" name="image" id="{{$name}}" onchange="preview()" />
        </div>

    @if ($errors->has($name))
        <span class="invalid-feedback" role="alert">
            {{ $errors->first($name) }}
        </span>
    @endif
</div>