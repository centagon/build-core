<select 
    name='{{ $name }}' 
    {!! $attributes !!}
    >
    @foreach ($options as $key=>$option)
        @if (is_array($option))
            <optgroup label='{{$key}}'>
                @foreach ($option as $value=>$label)
                
                <?php
                
                if($multiple) {
                    $selected = in_array($value, $old);
                } else {
                    $selected = ($value == $old);
                }
                
                ?>
                
                <option 
                    value='{{ $value }}' 
                    {{ $selected ? 'selected' : '' }}
                    >{{$label}}</option>
                @endforeach
            </optgroup>
        @else
            <?php
                
                if($multiple) {
                    $selected = in_array($key, $old);
                } else {
                    $selected = ($key == $old);
                }
                
            ?>
            <option value='{{$key}}' {{ $selected ? 'selected':'' }}>{{$option}}</option>
        @endif
    @endforeach
</select>