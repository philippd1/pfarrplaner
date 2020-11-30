<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <select class="form-control location-select @if(isset($class)){{ $class }}@endif" name="{{ $name }}" @if(isset($enabled) && (!$enabled)) disabled @endcannot >
        @if(isset($value) && isset($special) && (null === $value) && ($special != ''))<option data-time="" value="{{ $special }}" selected>{{ $special }}</option>
            @else <option></option>
        @endif
        @foreach($locations->sortBy('name') as $thisLocation)
            <option data-time="{{ strftime('%H:%M', strtotime($thisLocation->default_time)) }}"
                    value="{{$thisLocation->id}}"
                    @if (isset ($value) && (is_object($value)))
                        @if ($value->id == $thisLocation->id) selected @endif
                    @endif
            >
                {{$thisLocation->name}}
            </option>
        @endforeach
    </select>
    @include('partials.form.validation')
</div>
