<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Media</title>
</head>

<body>
    <h2>Upload Media</h2>

    @if ($errors->any())
        <div>
            <strong>Error:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="mediaForm" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Nama:</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama gambar">
        </div>
        <div class="form-group">
            <label for="name">Email:</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email">
        </div>
        <div class="form-group">
            <label for="name">Password:</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password">
        </div>
        <div class="form-group">
            <label for="file">Pilih Gambar:</label>
            <input type="file" name="file" id="file" class="form-control-file">
        </div>
        <button type="submit" class="btn btn-primary">Unggah Gambar</button>
    </form>
    <div id="uploadedImage"></div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#mediaForm').submit(function(event) {
                event.preventDefault(); // Prevent form submission
                var formData = new FormData($(this)[0]);
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#uploadedImage').html('<h2>Gambar yang diunggah:</h2><img src="' +
                            response.user.artwork_url_lg + '" alt="Uploaded Image">');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>

</body>

</html>
