@inject('jsonHelper', 'App\Helpers\JsonHelper')

<ul>
    @foreach ($data as $item)
        <li>
            <p>{{ $item->id }}</p>
            <strong>{{ $item->user_id }}</strong> (User ID)

            @if ($item->list !== null)
                : {!! $jsonHelper->convertJsonToHtmlList($item->list) !!}
            @endif

            <form action="{{ route('data.destroy', $item->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </li>
    @endforeach
</ul>

<script>
    function toggleJson(button) {
        let div = button.nextElementSibling;
        let isOpen = div.classList.contains('json-expanded');
        div.classList.toggle('json-expanded', !isOpen);
        div.classList.toggle('json-collapsed', isOpen);
        button.textContent = isOpen ? '+' : '-';
    }
</script>
