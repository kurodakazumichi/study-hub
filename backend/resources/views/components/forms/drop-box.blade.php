<select id="{{ $id }}" name="{{ $name }}">
  @if($hasEmpty)
    <option value="">--</option>
  @endif
  @foreach($options as $option)
    <option 
      value="{{ $option->id }}"
      @if($selected == $option->id) selected @endif
    >
      {{ $option->name }}
    </option>
  @endforeach
</select>