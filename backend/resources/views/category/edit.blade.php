<form action="/categories/{{ $category->id }}/" method="post">
  @csrf
  @method('PATCH')

  <label for="name">名前</label>
  <input type="text" name="name" value="{{ old('name', $category->name) }}">

  <label for="name">表示順</label>
  <input type="text" name="order" value="{{ old('name', $category->order) }}">

  <input type="submit" value="更新">
</form>