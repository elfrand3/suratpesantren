<!DOCTYPE html>
<html>
<head>
    <title>Daftar Postingan</title>
</head>
<body>
    <h1>Daftar Postingan</h1>

    @foreach ($posts as $post)
        <h2>{{ $post->title }}</h2>
        <div>{!! $post->content !!}</div>
        <hr>
    @endforeach

    <a href="{{ route('posts.create') }}">+ Tambah Baru</a>
</body>
</html> 