<?php

use App\Http\Controllers\SesiController;
use App\Http\Controllers\ControllerAdmin;
use App\Http\Controllers\PengasuhController;
use App\Http\Controllers\SekolahController;
use Illuminate\Support\Facades\Route;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\WordEditorController;

// Public routes
Route::get('/', function () {
    return view('login');
});
Route::post('/login', [SesiController::class, 'loginAkun'])->name('login');

Route::get('/login', function () {
    return view('login');
});

// Route AJAX untuk ambil template berdasarkan jenis surat
Route::get('/get-template/{jenis}', function ($jenis) {
    $jenis = str_replace('-', '_', $jenis); // agar 'izin-pulang' cocok dengan 'izin_pulang'
    $view = "surat_template.$jenis";

    if (!view()->exists($view)) {
        return response("Template tidak ditemukan.", 404);
    }

    return view($view)->render();
});


// Admin routes
Route::middleware(['auth'])->group(function () {
    // Route::get('/admin', function () {
    //     return view('admin.dasbord');
    // });

    Route::get('/admin', [ControllerAdmin::class, 'dasbord'])->name('admin.dasbord');

    Route::get('/admintemplatesurat', function () {
        return view('admin.templatesurat');
    });

    Route::get('/adminbuatsurat', function () {
        return view('admin.buatsurat');
    });
    Route::get('/buatsurat', function () {
        return view('admin.buatsurat');
    });
    Route::get('/admindaftarpembuatsurat', function () {
        return view('admin.daftarpembuatsurat');
    });
    Route::get('/admindaftarpembuatsurat', [ControllerAdmin::class, 'searchSantriInSurat'])->name('admin.surat.santri.search');
    Route::get('/adminpengaturan', function () {
        return view('admin.pengaturan');
    });

    // Template management routes
    Route::post('/upload/template/surat', [ControllerAdmin::class, 'storeTemplate'])->name('upload.template.surat');

    Route::get('/templates', [ControllerAdmin::class, 'templates'])->name('admin.templates');
    Route::get('/admintemplatesurat', [ControllerAdmin::class, 'templates'])->name('admin.templates.index');
    // Route::post('/templates', [ControllerAdmin::class, 'storeTemplate'])->name('admin.template.store');
    Route::get('/templates/{id}/content', [ControllerAdmin::class, 'getTemplateContent'])->name('admin.template.content');
    Route::put('/templates/{id}', [ControllerAdmin::class, 'updateTemplate'])->name('admin.template.update');
    Route::delete('/templates/{id}', [ControllerAdmin::class, 'deleteTemplate'])->name('admin.template.delete');
    Route::post('/admin/templates/{id}/toggle', [ControllerAdmin::class, 'toggleTemplateStatus'])->name('admin.template.toggle');
    Route::get('/templates/{id}/download', [ControllerAdmin::class, 'downloadTemplate'])->name('admin.template.download');
    Route::get('/templates/get/list', [ControllerAdmin::class, 'getTemplatesList'])->name('admin.templates.list');

    Route::post('/admin/santri', [ControllerAdmin::class, 'storeSantri'])->name('admin.santri.store');
    Route::get('/admindatasantri', [ControllerAdmin::class, 'getSantriList'])->name('admin.santri.list');
    Route::get('/admin/santri/{id}', [ControllerAdmin::class, 'detailSantri'])->name('admin.santri.detail');
    Route::get('/admin/santri/{id}/edit', [ControllerAdmin::class, 'editSantri'])->name('admin.santri.edit');
    Route::put('/admin/santri/{id}', [ControllerAdmin::class, 'updateSantri'])->name('admin.santri.update');
    Route::delete('/admin/santri/{id}', [ControllerAdmin::class, 'deleteSantri'])->name('admin.santri.delete');
    Route::get('/admin/santri/{id}/json', [ControllerAdmin::class, 'getSantriJson'])->name('admin.santri.json');
    Route::get('/admin/surat/create', [ControllerAdmin::class, 'createSurat'])->name('admin.surat.create');
    Route::post('/admin/surat', [ControllerAdmin::class, 'storeSurat'])->name('admin.surat.store');
    Route::get('/admin/surat', [ControllerAdmin::class, 'getSuratList'])->name('admin.surat.list');
    Route::get('/admin/surat/{id}', [ControllerAdmin::class, 'detailSurat'])->name('admin.surat.detail');
    // Route::get('/admin/surat/{id}/edit', [ControllerAdmin::class, 'editSurat'])->name('admin.surat.edit');
    Route::put('/admin/surat/{id}', [ControllerAdmin::class, 'editSurat'])->name('admin.surat.update');
    // Route::put('/admin/surat/{id}', [ControllerAdmin::class, 'updateSurat'])->name('admin.surat.update');
    Route::delete('/admin/surat/{id}', [ControllerAdmin::class, 'deleteSurat'])->name('admin.surat.delete');
    Route::get('/admin/surat/{id}/json', [ControllerAdmin::class, 'getSuratJson'])->name('admin.surat.json');
    Route::post('/admin/surat/search-santri', [ControllerAdmin::class, 'searchSantriByNis'])->name('admin.surat.search-santri');
    Route::post('/admin/surat/generate-nomor', [ControllerAdmin::class, 'generateNomorSurat'])->name('admin.surat.generate-nomor');
    Route::post('/admin/template/read-file', [ControllerAdmin::class, 'readTemplateFile'])->name('admin.template.readFile');
    Route::post('/admin/surat/store', [ControllerAdmin::class, 'storeSurat'])->name('admin.surat.store');

    Route::get('/export-surat', [ControllerAdmin::class, 'exportExcel'])->name('export.surat');


});

// Pengasuh routes
Route::middleware(['auth'])->group(function(){
    Route::get('/pengasuh', function () {
        return view('pengasuh.dasbordpengasuh');
    });
    Route::get('/pengasuhdaftarsurat', [PengasuhController::class, 'searchSantriInSurat'])->name('pengasuh.surat.santri.search');
    // Route::get('/pengasuhdatasantri', function () {
    //     return view('pengasuh.datasantri');
    // });
    Route::get('/pengasuhdatasantri', [PengasuhController::class, 'getSantriList'])->name('pengasuh.santri.list');
    Route::get('/pengasuh/santri/{id}', [PengasuhController::class, 'detailSantri'])->name('pengasuh.santri.detail');

    Route::get('/pengasuhdaftarsurat', function () {
        return view('pengasuh.datasurat');
    });
    Route::get('/pengasuh/surat/{id}', [PengasuhController::class, 'detailpengasuhSurat'])->name('pengasuh.surat.detail');
    Route::put('/pengasuh/surat/{id}', [PengasuhController::class, 'updatepengasuhSurat'])->name('pengasuh.surat.update');

    Route::get('/pengasuhpengaturan', function () {
        return view('pengasuh.pengaturan');
    });
});

// Sekolah routes
Route::middleware(['auth'])->group(function () {
    Route::get('/sekolah', function () {
        return view('sekolah.dasbordsekolah');
    });
    Route::get('/sekolahdatasantri', [SekolahController::class, 'getSantriList'])->name('sekolah.santri.list');
    Route::get('/sekolah/santri/{id}', [SekolahController::class, 'detailSantri'])->name('sekolah.santri.detail');

    Route::get('/sekolahdatasurat', function () {
        return view('sekolah.datasurat');
    });
    Route::get('/sekolah/surat/{id}', [SekolahController::class, 'detailsekolahSurat'])->name('sekolah.surat.detail');

    Route::get('/sekolahpengaturan', function () {
        return view('sekolah.pengaturan');
    });


});


// Logout route
Route::post('/logout', [SesiController::class, 'logoutAkun'])->name('logout');

Route::get('/api/surat', function () {
    return \App\Models\surat::with('santri')->get();
});

Route::get('/posts/create', function () {
    return view('posts.create');
})->name('posts.create');

Route::post('/posts', function (Request $request) {
    $validated = $request->validate([
        'title' => 'required|string',
        'content' => 'required|string',
    ]);

    Post::create($validated);

    return redirect()->route('posts.index');
})->name('posts.store');

Route::get('/posts', function () {
    $posts = Post::latest()->get();
    return view('posts.index', compact('posts'));
})->name('posts.index');

// Word Editor routes
Route::get('/word/upload', [WordEditorController::class, 'uploadForm'])->name('word.upload');
Route::post('/word/upload', [WordEditorController::class, 'handleUpload'])->name('word.handleUpload');
Route::post('/word/save', [WordEditorController::class, 'saveEdited'])->name('word.save');

Route::get('/exportpdf/{id}', [ControllerAdmin::class, 'exportPDF'])->name('surat.exportpdf');

// Route::get('/p', function () {
//         return view('surat_template.exportpdf');
//     });
