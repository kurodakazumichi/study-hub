@if (0 < count($errors))
<ul>
  @foreach($errors->all() as $err)
  <li>{{ $err }}</li>
  @endforeach
</ul>
@endif
<form method="post" action="/categories/store">
  @csrf
  <label for="name">名前</label>
  <input type="text" name="name" value="{{ old('name') }}">
  <label for="order">表示順</label>
  <input type="text" name="order" value="{{ old('order') }}">
  <input type="submit" value="送信">
</form>