<select id="{{ $id }}" name="{{ $name }}">
  @if($hasEmpty)
    <option value="">--</option>
  @endif
  @foreach($options as $key => $value)
    <option 
      value="{{ $key }}"
      @if($selected == $key) selected @endif
    >
      {{ $value }}
    </option>
  @endforeach
</select>