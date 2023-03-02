<form id="update-data">
    @csrf
    <div class="form-group">
        <label for="code">Insert PHP Code:</label>
        <textarea class="form-control" id="code" name="code" rows="5" required></textarea>
    </div>
    <label for="method">Choose a request method:</label>
    <select name="method" id="method" required>
        <option value="GET">Get</option>
        <option value="POST" selected>Post</option>
    </select>
    <div class="form-group">
        <label for="token">Token:</label>
        <textarea class="form-control" id="token" name="token" rows="4" required></textarea>
    </div>
    <label for="id"></label>
    <input id="id" name="id" value="{{ $data->id }}" hidden>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function () {
        $('#update-data').submit(function (event) {
            event.preventDefault();
            let method = $('#method').val();
            let code = $('#code').val();
            let id = $('#id').val();
            let token = $('#token').val();
            let url = '{{ route('data.update', ':id') }}';
            url.replace(':id', id);
            if (method === 'GET') {
                url += '?id=' + encodeURIComponent(id) +
                    '&code=' + encodeURIComponent(code) +
                    '&token=' + encodeURIComponent(token);
                window.location.href = url;
            } else {
                $.post(url, {id: id, code: code, token: token}, function (response) {
                    console.log(response);
                }).fail(function (xhr) {
                    console.log(xhr.responseText);
                });
            }
        });
    });
</script>



