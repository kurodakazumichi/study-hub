<h1>日報</h1>

@foreach($studies as $study)
<section>
  <h2>{{ $study->name }}</h2>

  <ul>
  @foreach($study->indices as $index)
    <li>{{ $index->title }}</li>
  @endforeach
  </ul>
</section>
@endforeach