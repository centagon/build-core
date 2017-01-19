<select 
    name='{{ $name }}' 
    {!! $attributes !!}
    >
    @foreach ($options as $key=>$option)
        @if (is_array($option))
            <optgroup label='{{$key}}'>
                @foreach ($option as $value=>$label)
                <option value='{{ $value }}' {{ ($value==old($name, $default))?'selected':'' }}>{{$label}}</option>
                @endforeach
            </optgroup>
        @else
            <option value='{{$key}}' {{ ($key==old($name, $default))?'selected':'' }}>{{$option}}</option>
        @endif
    @endforeach
</select>