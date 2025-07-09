<!DOCTYPE html>
<html lang="en" translate="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" content="notranslate">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manajemen Template Surat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('scrib/scrib.css') }}">
    <script src="{{ asset('scrib/scrib.js') }}"></script>
    <script src="https://cdn.tiny.cloud/1/bl7rwlx3nqnrk8eahlvshktp2b9mpfrd1uffg8dy2y94jcnz/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <style>
        .template-card {
            transition: all 0.3s ease;
        }
        .template-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .file-upload-area {
            border: 2px dashed #d1d5db;
            transition: all 0.3s ease;
        }
        .file-upload-area:hover {
            border-color: #3b82f6;
            background-color: #f8fafc;
        }
        .file-upload-area.dragover {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('components.sidebar')

    <!-- Main Content -->
    <div class="ml-72 pt-16">
        @include('components.navbar', ['title' => 'Template Surat'])

        <main class="p-6">
            <div class="w-full max-w-7xl mx-auto">
                <!-- Header Section -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">Manajemen Template Surat</h1>
                            <p class="text-gray-600 mt-2">Upload dan kelola template surat yang akan digunakan dalam pembuatan surat</p>
                        </div>
                        <button onclick="openAddTemplateModal()" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                            <i class="fas fa-plus mr-2"></i> Tambah Template
                        </button>
                    </div>
                </div>

                <!-- Template List -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-800">Daftar Template</h2>
                        <div class="text-sm text-gray-600">
                            <span id="templateCount">{{ $templates->count() }}</span> template ditemukan
                        </div>
                    </div>
                    
                    <!-- Filter Section -->
                    <div class="mb-6">
                        <div class="flex flex-wrap gap-4 items-end">
                            <div class="flex-1 min-w-48">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Template</label>
                                <div class="relative">
                                    <input type="text" id="searchQuery" placeholder="Cari nama template..." class="w-full px-3 py-2 pl-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                            </div>
                            <div class="flex-1 min-w-48">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Filter Jenis Template Surat</label>
                                <select id="filterJenisSurat" onchange="filterTemplates()" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Semua Jenis Surat</option>
                                    <option value="Surat Izin Pulang">Surat Izin Pulang</option>
                                    <option value="Surat Keterangan Sakit">Surat Keterangan Sakit</option>
                                    <option value="Surat Rekomendasi">Surat Rekomendasi</option>
                                </select>
                            </div>
                            <div class="flex-1 min-w-48">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select id="filterStatus" onchange="filterTemplates()" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Semua Status</option>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Tidak Aktif">Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="min-w-32">
                                <button onclick="clearFilters()" class="w-full px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                                    <i class="fas fa-times mr-2"></i>Clear
                                </button>
                            </div>
                        </div>                        
                    </div>

                    <!-- Templates Grid -->
                    <div id="templatesGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($templates as $template)
                        <div class="template-card bg-white border border-gray-200 rounded-lg p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $template->nama_template }}</h3>
                                    <p class="text-sm text-gray-600">{{ $template->jenis_surat }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="flex items-center">
                                        <span class="inline-block w-2 h-2 rounded-full mr-2 {{ $template->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                        <span class="px-2 py-1 text-xs rounded-full font-semibold {{ $template->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $template->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                            
                            @if($template->deskripsi)
                            <p class="text-sm text-gray-600 mb-4">{{ Str::limit($template->deskripsi, 100) }}</p>
                            @endif

                            @if($template->file_name)
                            <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-file text-blue-600 mr-2"></i>
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">{{ $template->file_name }}</p>
                                            <p class="text-xs text-gray-500">{{ $template->file_size_human }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.template.download', $template->id) }}" class="text-blue-600 hover:text-blue-800" title="Download">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                            @endif

                            <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                                <div class="text-xs text-gray-500">
                                    Dibuat: {{ $template->created_at->format('d/m/Y H:i') }}
                                </div>
                                <div class="flex items-center space-x-2">
                                    <button onclick="editTemplate({{ $template->id }})" class="text-blue-600 hover:text-blue-800" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="toggleTemplateStatus({{ $template->id }})" class="text-yellow-600 hover:text-yellow-800" title="Toggle Status">
                                        <i class="fas fa-toggle-on"></i>
                                    </button>
                                    <button onclick="deleteTemplate({{ $template->id }})" class="text-red-600 hover:text-red-800" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @if($templates->isEmpty())
                    <div class="text-center py-12">
                        <i class="fas fa-search text-4xl text-gray-400 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-600 mb-2">
                            @if(request('q') || request('jenis_surat') || request('status'))
                                Tidak ada template yang sesuai dengan filter
                            @else
                                Belum ada template
                            @endif
                        </h3>
                        <p class="text-gray-500 mb-4">
                            @if(request('q') || request('jenis_surat') || request('status'))
                                Coba ubah filter pencarian Anda atau 
                                <button onclick="clearFilters()" class="text-blue-600 hover:text-blue-800 underline">reset filter</button>
                            @else
                                Mulai dengan menambahkan template surat pertama Anda
                            @endif
                        </p>
                        @if(!request('q') && !request('jenis_surat') && !request('status'))
                        <button onclick="openAddTemplateModal()" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Tambah Template
                        </button>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <!-- Add/Edit Template Modal -->
    <div id="templateModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-4xl mx-4 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 id="modalTitle" class="text-xl font-semibold text-gray-800">Tambah Template Baru</h3>
                <button onclick="closeTemplateModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{route('upload.template.surat')}}" data-add-action="{{route('upload.template.surat')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="templateId" name="template_id">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Info -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Template *</label>
                            <input type="text" id="namaTemplate" name="nama_template" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Surat *</label>
                            <select id="jenisSurat" name="jenis_surat" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih Jenis Surat</option>
                                <option value="Surat Izin Pulang">Surat Izin Pulang</option>
                                <option value="Surat Keterangan Sakit">Surat Keterangan Sakit</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                            <textarea id="deskripsi" name="deskripsi" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Deskripsi singkat tentang template ini..."></textarea>
                        </div>
                    </div>

                    <!-- File Upload -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">File Template *</label>
                            <div id="fileUploadArea" class="file-upload-area rounded-lg p-6 text-center cursor-pointer">
                                <input type="file" id="templateFile" name="template_file" accept=".docx" class="hidden">
                                <div id="uploadContent">
                                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-3"></i>
                                    <p class="text-gray-600 mb-2">Klik atau drag file ke sini</p>
                                    <p class="text-sm text-gray-500">Format: DOCX (Max: 10MB)</p>
                                </div>
                                <div id="fileInfo" class="hidden">
                                    <div class="flex items-center justify-center">
                                        <i class="fas fa-file text-blue-600 mr-2"></i>
                                        <span id="fileName" class="text-sm font-medium"></span>
                                    </div>
                                    <button type="button" onclick="removeFile()" class="text-red-600 text-sm mt-2 hover:text-red-800">
                                        <i class="fas fa-times mr-1"></i>Hapus File
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- HTML Content Editor -->
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2"> Isi Surat</label>
                    <textarea id="contentHtml" name="content_html" class="w-full min-h-[300px] border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 scrib-editor" placeholder="Masukkan template ..."></textarea>
                    <p class="text-xs text-gray-500 mt-1"> Masukkan Data Template Surat Yang Akan Disimpan</p>
                </div>

                <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
                    <button type="button" onclick="closeTemplateModal()" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit" id="submitBtn" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>Simpan Template
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // File upload handling
        const fileUploadArea = document.getElementById('fileUploadArea');
        const templateFile = document.getElementById('templateFile');
        const uploadContent = document.getElementById('uploadContent');
        const fileInfo = document.getElementById('fileInfo');
        const fileName = document.getElementById('fileName');

        fileUploadArea.addEventListener('click', () => templateFile.click());
        
        fileUploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            fileUploadArea.classList.add('dragover');
        });
        
        fileUploadArea.addEventListener('dragleave', () => {
            fileUploadArea.classList.remove('dragover');
        });
        
        fileUploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            fileUploadArea.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                templateFile.files = files;
                handleFileSelect(files[0]);
            }
        });
        
        templateFile.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                handleFileSelect(e.target.files[0]);
            }
        });

        function handleFileSelect(file) {
            if (file.size > 10 * 1024 * 1024) { // 10MB
                alert('File terlalu besar. Maksimal 10MB.');
                return;
            }
            
            fileName.textContent = file.name;
            uploadContent.classList.add('hidden');
            fileInfo.classList.remove('hidden');
        }

        function removeFile() {
            templateFile.value = '';
            uploadContent.classList.remove('hidden');
            fileInfo.classList.add('hidden');
        }

        // Modal functions
        function openAddTemplateModal() {
            document.getElementById('modalTitle').textContent = 'Tambah Template Baru';
            document.getElementById('templateId').value = '';
            document.getElementById('namaTemplate').value = '';
            document.getElementById('jenisSurat').value = '';
            document.getElementById('deskripsi').value = '';
            if (tinymce.get('contentHtml')) {
                tinymce.get('contentHtml').setContent('');
            } else {
                document.getElementById('contentHtml').value = '';
            }
            removeFile();
            // Set form action and method for add
            const form = document.querySelector('#templateModal form');
            form.action = form.getAttribute('data-add-action') || form.action;
            form.method = 'POST';
            // Remove _method if exists
            let methodInput = form.querySelector('input[name="_method"]');
            if (methodInput) methodInput.remove();
            document.getElementById('templateModal').classList.remove('hidden');
        }

        function closeTemplateModal() {
            document.getElementById('templateModal').classList.add('hidden');
        }

        function editTemplate(id) {
            fetch(`/templates/${id}/content`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('modalTitle').textContent = 'Edit Template';
                        document.getElementById('templateId').value = data.template.id;
                        document.getElementById('namaTemplate').value = data.template.nama_template || '';
                        document.getElementById('jenisSurat').value = data.template.jenis_surat || '';
                        document.getElementById('deskripsi').value = data.template.deskripsi || '';
                        if (tinymce.get('contentHtml')) {
                            tinymce.get('contentHtml').setContent(data.template.content_html || '');
                        } else {
                            document.getElementById('contentHtml').value = data.template.content_html || '';
                        }
                        if (data.template.file_name) {
                            fileName.textContent = data.template.file_name;
                            uploadContent.classList.add('hidden');
                            fileInfo.classList.remove('hidden');
                        } else {
                            removeFile();
                        }
                        // Set form action and method for edit
                        const form = document.querySelector('#templateModal form');
                        form.action = `/templates/${id}`;
                        form.method = 'POST';
                        // Add _method=PUT for Laravel
                        let methodInput = form.querySelector('input[name="_method"]');
                        if (!methodInput) {
                            methodInput = document.createElement('input');
                            methodInput.type = 'hidden';
                            methodInput.name = '_method';
                            form.appendChild(methodInput);
                        }
                        methodInput.value = 'PUT';
                        document.getElementById('templateModal').classList.remove('hidden');
                    }
                });
        }
        // Template management functions
        function deleteTemplate(id) {
            console.log('deleteTemplate called', id);
            if (confirm('Apakah Anda yakin ingin menghapus template ini?')) {
                fetch(`/templates/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification(data.message, 'success');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showNotification(data.message, 'error');
                    }
                })
            }
        }

        function toggleTemplateStatus(id) {
            fetch(`/admin/templates/${id}/toggle`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                showNotification('Terjadi kesalahan saat mengubah status template', 'error');
            });
        }

        function filterTemplates() {
            applySearch();
        }

        function applySearch() {
            const searchQuery = document.getElementById('searchQuery').value;
            const jenisSurat = document.getElementById('filterJenisSurat').value;
            const status = document.getElementById('filterStatus').value;
            
            // Build filter parameters
            const params = new URLSearchParams();
            if (searchQuery) params.append('q', searchQuery);
            if (jenisSurat) params.append('jenis_surat', jenisSurat);
            if (status) {
                // Convert status text to boolean for backend
                const statusValue = status === 'Aktif' ? 1 : 0;
                params.append('status', statusValue);
            }
            
            // Redirect to the correct route
            window.location.href = `/admintemplatesurat?${params.toString()}`;
        }

        function clearFilters() {
            // Reset filter values
            document.getElementById('searchQuery').value = '';
            document.getElementById('filterJenisSurat').value = '';
            document.getElementById('filterStatus').value = '';
            
            // Redirect to the page without any filters
            window.location.href = '/admintemplatesurat';
        }

        // Notification function
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500'} text-white`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Close modal when clicking outside
        document.getElementById('templateModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeTemplateModal();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Set filter values from URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const searchQuery = urlParams.get('q');
            const jenisSurat = urlParams.get('jenis_surat');
            const status = urlParams.get('status');
            
            if (searchQuery) {
                document.getElementById('searchQuery').value = searchQuery;
            }
            if (jenisSurat) {
                document.getElementById('filterJenisSurat').value = jenisSurat;
            }
            if (status) {
                // Convert boolean back to display text
                const statusText = status == 1 ? 'Aktif' : 'Tidak Aktif';
                document.getElementById('filterStatus').value = statusText;
            }

            // Add Enter key handler for search input
            document.getElementById('searchQuery').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    applySearch();
                }
            });
            
            initScribEditor('contentHtml');
            tinymce.init({
                selector: '#contentHtml',
                height: 'auto',
                min_height: 300,
                max_height: 800,
                menubar: true,
                resize: false,
                autoresize_bottom_margin: 10,
                autoresize_overflow_padding: 10,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount', 'autoresize'
                ],
                toolbar: 'undo redo | formatselect | bold italic underline strikethrough | ' +
                         'alignleft aligncenter alignright alignjustify | ' +
                         'bullist numlist outdent indent | removeformat | table | help',
                content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; line-height: 1.6; margin: 0; padding: 10px; }',
                placeholder: 'Masukkan konten HTML template di sini...',
                setup: function(editor) {
                    editor.on('change', function() {
                        editor.save();
                    });
                    editor.on('init', function() {
                        editor.execCommand('mceAutoResize');
                    });
                    editor.on('keyup', function() {
                        editor.execCommand('mceAutoResize');
                    });
                    editor.on('paste', function() {
                        setTimeout(function() {
                            editor.execCommand('mceAutoResize');
                        }, 100);
                    });
                    editor.on('SetContent', function() {
                        setTimeout(function() {
                            editor.execCommand('mceAutoResize');
                        }, 50);
                    });
                }
            });
        });

        // Setelah TinyMCE init
        document.getElementById('templateFile').addEventListener('change', function(e) {
            var file = e.target.files[0];
            if (!file) return;
            var formData = new FormData();
            formData.append('template_file', file);

            fetch('/admin/template/read-file', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.content_html) {
                    if (tinymce.get('contentHtml')) {
                        tinymce.get('contentHtml').setContent(data.content_html);
                    } else {
                        document.getElementById('contentHtml').value = data.content_html;
                    }
                }
            });
        });
    </script>
</body>
</html>