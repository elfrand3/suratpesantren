<!DOCTYPE html>
<html>
<head>
    <title>Buat Postingan</title>
    <script src="https://unpkg.com/scribe-editor@1.5.0/bundle/scribe.min.js"></script>
    <style>
        #editor {
            border: 1px solid #ccc;
            padding: 10px;
            min-height: 200px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>Buat Postingan</h1>

    <form method="POST" action="{{ route('posts.store') }}">
        @csrf
        <label>Judul:</label><br>
        <input type="text" name="title" required><br><br>

        <label>Konten:</label><br>
        <div id="editor" contenteditable="true">Tulis artikel di sini...</div>
        <textarea name="content" id="hiddenContent" style="display:none;"></textarea>

        <br>
        <button type="submit">Simpan</button>
    </form>

    <script>
        var editorDiv = document.getElementById('editor');
        var scribe = new Scribe(editorDiv);

        document.querySelector('form').addEventListener('submit', function () {
            document.getElementById('hiddenContent').value = editorDiv.innerHTML;
        });
    </script>
</body>
</html> 