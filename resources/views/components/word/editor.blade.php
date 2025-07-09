<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Dokumen</title>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
</head>
<body>
    <h2>Edit Isi Surat</h2>
    <form method="POST" action="{{ route('word.save') }}">
        @csrf
        <textarea name="isi_surat" id="editor">{!! isset($htmlContent) ? $htmlContent : '' !!}</textarea>
        <br><br>
        <button type="submit">Simpan ke Word</button>
    </form>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => console.error(error));
    </script>
</body>
</html>