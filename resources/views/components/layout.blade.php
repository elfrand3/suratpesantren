@if (empty(Auth::user()->role))
    <script>
    window.location.href = "/login";
  </script>
@endif