<div class="form-group row">
    <label for="{{$name}}" class="col-md-4 col-form-label text-md-right">{{$label}}</label>

<div class="col-md-6">
<textarea class="textarea" name="{{$name}}" id="{{$name}}">@isset(($object->{$name})) {{old($name) ? old($name) : $object->{$name} }}
@else {{old($name)}} @endisset</textarea>

            @if($errors->has($name))
                <span class="invalid-feedback" role="alert">
                    {{ $errors->first($name) }}
                </span>
            @endif
        </div>
</div>