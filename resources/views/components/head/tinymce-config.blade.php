<div>
    <!-- Happiness is not something readymade. It comes from your own actions. - Dalai Lama -->
</div>

<script src="https://cdn.tiny.cloud/1/{{ config('services.tinymce.api_key', 'YOUR_API_KEY_HERE') }}/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: 'textarea#myeditorinstance', // Replace this CSS selector to match the placeholder element for TinyMCE
    plugins: 'code table lists',
    toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
  });
</script>