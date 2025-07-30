<div>
    <!-- Because you are alive, everything is possible. - Thich Nhat Hanh -->
</div>

<form method="post" class="space-y-4">
    <div class="form-group">
        <label for="myeditorinstance" class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-edit mr-2"></i>Editor Teks
        </label>
        <textarea
            id="myeditorinstance"
            name="content"
            class="w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            placeholder="Ketik konten Anda di sini..."
            rows="10">Hello, World!</textarea>
        <p class="text-xs text-gray-500 mt-1">
            <i class="fas fa-info-circle mr-1"></i>
            Gunakan toolbar di atas untuk memformat teks, menambahkan tabel, dan mengatur tata letak
        </p>
    </div>

    <div class="flex justify-end space-x-3">
        <button type="button" onclick="clearEditor()" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
            <i class="fas fa-eraser mr-2"></i>Bersihkan
        </button>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
            <i class="fas fa-save mr-2"></i>Simpan
        </button>
    </div>
</form>

<script>
function clearEditor() {
    if (tinymce.get('myeditorinstance')) {
        tinymce.get('myeditorinstance').setContent('');
    }
}
</script>
