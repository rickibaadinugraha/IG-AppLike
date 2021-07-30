<div>
    
<textarea class="textarea form-control" name="{{$name}}" id="{{$name}}">
@isset(($object->{$name})) {{old($name) ? old($name) : $object->{$name} }}
@else {{old($name)}} @endisset
</textarea>

            @if($errors->has($name))
                <span class="invalid-feedback" role="alert">
                    {{ $errors->first($name) }}
                </span>
            @endif
</div>