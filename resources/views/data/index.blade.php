<ul>
    @foreach ($data as $item)
        <li>
            <p>{{ $item->id }}</p>
            <strong>{{ $item->user_id }}</strong> (User ID)

            @if ($item->list !== null)
                : {{ $item->list }}
            @endif

            <form action="{{ route('data.destroy', $item->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </li>
    @endforeach
</ul>
