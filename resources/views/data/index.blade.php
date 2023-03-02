@inject('jsonHelper', 'App\Helpers\JsonHelper')

<ul class="json-list">
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
    document.querySelectorAll('.toggle-button').forEach(button => {
        button.addEventListener('click', () => {
            const li = button.parentNode;
            const ul = li.querySelector('ul');

            if (ul) {
                const shouldShow = ul.style.display === 'none';
                ul.style.display = shouldShow ? 'block' : 'none';
                button.innerText = shouldShow ? '-' : '+';
            }
        });
    });
</script>
