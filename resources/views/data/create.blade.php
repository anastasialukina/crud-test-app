<form id="create-data">
    @csrf
    <div class="form-group">
        <label for="data">Data:</label>
        <textarea class="form-control" id="data" name="data" rows="5" required></textarea>
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
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function () {
        $('#create-data').submit(function (event) {
            event.preventDefault();
            let method = $('#method').val();
            let data = $('#data').val();
            let token = $('#token').val();
            let url = '{{ route('data.store') }}';
            if (method === 'GET') {
                url += '?data=' + encodeURIComponent(data) + '?token=' + encodeURIComponent(token);
                window.location.href = url;
            } else {
                $.post(url, {data: data, token: token}, function (response) {
                    console.log(response);
                }).fail(function (xhr) {
                    console.log(xhr.responseText);
                });
            }
        });
    });
</script>


