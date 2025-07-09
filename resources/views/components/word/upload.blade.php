<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Dokumen Word</title>
</head>
<body>
    <h2>Upload Dokumen Word (.doc/.docx)</h2>
    <form method="POST" action="{{ route('word.handleUpload') }}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" accept=".doc,.docx" required>
        <button type="submit">Upload & Edit</button>
    </form>
</body>
</html>