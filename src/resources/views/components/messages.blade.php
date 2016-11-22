@foreach (alert()->messages() as $key => $messages)
    @foreach ($messages as $message)
        <div class="panel panel--{{ $key }}">
            {{ $message }}
        </div>
    @endforeach
@endforeach