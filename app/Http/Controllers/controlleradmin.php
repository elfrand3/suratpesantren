<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\surat;
use App\Models\template_surat;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpWord\IOFactory;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Http;

class ControllerAdmin extends Controller
{
    public function dasbord() {

        $totalSurat = Surat::count(); // hitung semua data surat
        $suratDisetujui = Surat::where('status', 'disetujui')->count(); // hitung surat yang disetujui
        $suratMenunggu = Surat::where('status', 'pending')->count(); // hitung surat yang menunggu
        $santri = Santri::count(); // ambil semua data santri

        return view('admin.dasbord', [
            'totalSurat' => $totalSurat,
            'santri' => $santri,
            'suratDisetujui' => $suratDisetujui,
            'suratMenunggu' => $suratMenunggu,
        ]);
    }

    public function getSantriList(Request $request)
    {
        $query = $request->input('q');
        $status = $request->input('status');
        $kelas = $request->input('kelas');
        $santris = Santri::query();
        if ($query) {
            $santris = $santris->where(function($qobj) use ($query) {
                $qobj->where('nama', 'like', "%{$query}%")
                  ->orWhere('nis', 'like', "%{$query}%")
                  ->orWhere('kelas', 'like', "%{$query}%")
                  ->orWhere('alamat', 'like', "%{$query}%")
                  ->orWhere('tempat_lahir', 'like', "%{$query}%")
                  ->orWhere('nama_ortu', 'like', "%{$query}%");
            });
        }
        if ($status) {
            $santris = $santris->where('status', $status);
        }
        if ($kelas) {
            $santris = $santris->where('kelas', $kelas);
        }
        $santris = $santris->get();
        return view('admin.datasantri', [
            'santris' => $santris,
            'search' => $query
        ]);
    }

    public function storeSantri(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|unique:santris,nis',
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'kelas' => 'required',
            'status' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'nama_ortu' => 'required',
            'alamat_ortu' => 'required',
        ]);
        $santri = \App\Models\santri::create($validated);
        return redirect()->back()->with('success', 'Santri berhasil ditambahkan');
    }


    public function detailSantri($id)
    {
        $santriDetail = \App\Models\santri::findOrFail($id);
        $santris = \App\Models\santri::all();
        return view('admin.datasantri', compact('santris', 'santriDetail'));
    }

    public function editSantri($id)
    {
        $santriEdit = \App\Models\santri::findOrFail($id);
        $santris = \App\Models\santri::all();
        return view('admin.datasantri', compact('santris', 'santriEdit'));
    }

    public function updateSantri(Request $request, $id)
    {
        $santri = \App\Models\santri::findOrFail($id);
        $validated = $request->validate([
            'nis' => 'required|unique:santris,nis,' . $id,
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'kelas' => 'required',
            'status' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'nama_ortu' => 'required',
            'alamat_ortu' => 'required',
        ]);
        $santri->update($validated);
        return redirect()->route('admin.santri.list')->with('success', 'Data santri berhasil diupdate');
    }

    public function deleteSantri($id)
    {
        $santri = \App\Models\santri::findOrFail($id);
        $santri->delete();
        return redirect()->route('admin.santri.list')->with('success', 'Data santri berhasil dihapus');
    }

    public function getSantriJson($id)
    {
        $santri = \App\Models\santri::findOrFail($id);
        return response()->json($santri);
    }

    public function searchSantriInSurat(Request $request)
    {
        $query = $request->input('q');
        $santris = [];
        if ($query) {
            $santris = \App\Models\santri::where('nama', 'like', "%{$query}%")
                ->orWhere('nis', 'like', "%{$query}%")
                ->get();
        } else {
            $santris = \App\Models\santri::all();
        }
        return view('admin.daftarpembuatsurat', [
            'santris' => $santris,
            'search' => $query
        ]);
    }

    // Surat Management Methods
    public function createSurat()
    {
        $santris = \App\Models\Santri::all();
        return view('admin.buatsurat', compact('santris'));
    }

    public function storeSurat(Request $request)
    {

        // dd($request->all());
        $validated = $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'nomor_surat' => 'required|string|unique:surats,nomor_surat',
            'tanggal_surat' => 'required|date',
            'tanggal_kembali' => 'nullable|date',
            'jenis_surat' => 'required|string',
            'status' => 'required|string',
            'alasan' => 'nullable|string',
            'diagnosa' => 'nullable|string',
            'content' => 'required|string',
        ]);

        Surat::create($validated);
        $santri = Santri::find($request->santri_id);

    if (!$santri) {
        return redirect()->back()->with('error', 'Santri tidak ditemukan.');
    }

    // Format pesan WA
    $pesan = "*📄 Surat Baru Diterbitkan*\n"
           . "Nama: *{$santri->nama}*\n"
           . "Jenis Surat: *{$request->jenis_surat}*\n"
           . "Nomor Surat: *{$request->nomor_surat}*\n"
           . "Tanggal Surat: *{$request->tanggal_surat}*\n\n"
           . "Silakan cek detail di sistem atau hubungi pengurus.";

    // Kirim WA lewat Fonnte
    Http::withOptions(['verify' => false])->withHeaders([
        'Authorization' => '9fd5BVdFtu6m4tYmHYMQ'
    ])->post('https://api.fonnte.com/send', [
        'target' => $santri->no_telp, // pastikan field ini ada dan format 628xxx
        'message' => $pesan,
    ]);
        // dd($validated);
        return redirect()->back()->with('success', 'Surat berhasil disimpan.');

    }


    // public function storeSurat(Request $request)
    // {
    //     $validated = $request->validate([
    //         'nomor_surat' => 'required|unique:surats,nomor_surat',
    //         'jenis_surat' => 'required',
    //         'tanggal_surat' => 'required|date',
    //         'perihal' => 'required',
    //         'status' => 'required',
    //         'template_surat' => 'nullable',
    //         'nis' => 'required',
    //         'nama_santri' => 'required',
    //         'alasan' => 'nullable',
    //         'diagnosa' => 'nullable',
    //         'tanggal_kembali' => 'nullable|date',
    //         'content' => 'nullable',
    //         'santri_id' => 'nullable|exists:santris,id',
    //         'file_surat' => 'nullable|file|mimes:pdf,doc,docx|max:2048'
    //     ]);

    //     // Handle file upload if present
    //     if ($request->hasFile('file_surat')) {
    //         $file = $request->file('file_surat');
    //         $fileName = time() . '_' . $file->getClientOriginalName();
    //         $file->storeAs('public/surats', $fileName);
    //         $validated['file_surat'] = $fileName;
    //     }

    //     // Find santri by NIS if santri_id is not provided
    //     if (!$validated['santri_id']) {
    //         $santri = \App\Models\santri::where('nis', $validated['nis'])->first();
    //         if ($santri) {
    //             $validated['santri_id'] = $santri->id;
    //         }
    //     }

    //     $surat = \App\Models\surat::create($validated);

    //     return redirect()->route('admin.surat.list')->with('success', 'Surat berhasil dibuat');
    // }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_surat' => 'required',
            'nama_santri' => 'required',
            'nis' => 'required',
            'tanggal_surat' => 'required|date',
            'tanggal_kembali' => 'nullable|date',
            'alasan' => 'nullable|string',
            'diagnosa' => 'nullable|string',
            'nomor_surat' => 'required|unique:surats,nomor_surat',
        ]);

        $jenis = str_replace('-', '_', $request->jenis_surat);
        $templatePath = "surat_template.$jenis";

        if (!view()->exists($templatePath)) {
            return back()->with('error', 'Template surat tidak ditemukan.');
        }

        $isiSurat = view($templatePath, [
            'nama_santri' => $request->nama_santri,
            'nis' => $request->nis,
            'tanggal_surat' => $request->tanggal_surat,
            'tanggal_kembali' => $request->tanggal_kembali,
            'alasan' => $request->alasan,
            'diagnosa' => $request->diagnosa,
        ])->render();

        // Simpan ke database atau tampilkan kembali
        Surat::create([
            'nomor_surat' => $request->nomor_surat,
            'jenis_surat' => $request->jenis_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'content' => $isiSurat,
            // tambahkan field lain sesuai kolom database kamu
        ]);

        return redirect()->route('admin.surat.index')->with('success', 'Surat berhasil dibuat.');
    }

    private function kirimWaFonnte($nomor, $pesan)
    {
        $token = '4D27rRQAhcTCxE1Z23YGJEVa7gtiN5rQQBhP2V'; // <-- ganti dengan token kamu dari Fonnte

        // Ubah nomor 08xxx → 628xxx jika perlu
        $nomor = trim($nomor);
        if (strpos($nomor, '+62') === 0) {
            $nomor = str_replace('+62', '62', $nomor);
        } elseif (strpos($nomor, '0') === 0) {
            $nomor = '62' . substr($nomor, 1);
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.fonnte.com/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'target' => $nomor,
                'message' => $pesan,
                'delay' => 2
            ],
            CURLOPT_HTTPHEADER => [
                "Authorization: $token"
            ],
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        // Optional: untuk debugging
        \Log::info("WA ke $nomor: $response");
    }

    public function getSuratList(Request $request)
    {
        $query = $request->input('q');
        $jenis_surat = $request->input('jenis_surat');
        $status = $request->input('status');

        $surats = \App\Models\surat::with('santri');

        if ($query) {
            $surats = $surats->where(function($qobj) use ($query) {
                $qobj->where('nomor_surat', 'like', "%{$query}%")
                  ->orWhere('nama_santri', 'like', "%{$query}%")
                  ->orWhere('nis', 'like', "%{$query}%")
                  ->orWhere('perihal', 'like', "%{$query}%");
            });
        }

        if ($jenis_surat) {
            $surats = $surats->where('jenis_surat', $jenis_surat);
        }

        if ($status) {
            $surats = $surats->where('status', $status);
        }

        $surats = $surats->orderBy('created_at', 'desc')->get();

        return view('admin.daftarpembuatsurat', [
            'surats' => $surats,
            'search' => $query
        ]);
    }

    public function detailSurat($id)
    {
        $surat = \App\Models\surat::with('santri')->findOrFail($id);
        return view('admin.detailSurat', compact('surat'));
    }

    public function editSurat($id)
    {
        $surat = \App\Models\surat::findOrFail($id);
        $santris = Santri::all();
        return view('admin.editSurat', compact('surat', 'santris'));
    }

    public function updateSurat(Request $request, $id)
    {
        $surat = \App\Models\surat::findOrFail($id);

        $validated = $request->validate([
            'nomor_surat' => 'required|unique:surats,nomor_surat,' . $id,
            'jenis_surat' => 'required',
            'tanggal_surat' => 'required|date',
            'perihal' => 'required',
            'status' => 'required',
            'template_surat' => 'nullable',
            'nis' => 'required',
            'nama_santri' => 'required',
            'alasan' => 'nullable',
            'diagnosa' => 'nullable',
            'tanggal_kembali' => 'nullable|date',
            'content' => 'nullable',
            'santri_id' => 'nullable|exists:santris,id',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx|max:2048'
        ]);

        // Handle file upload if present
        if ($request->hasFile('file_surat')) {
            // Delete old file if exists
            if ($surat->file_surat) {
                Storage::delete('public/surats/' . $surat->file_surat);
            }

            $file = $request->file('file_surat');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/surats', $fileName);
            $validated['file_surat'] = $fileName;
        }

        // Find santri by NIS if santri_id is not provided
        if (!$validated['santri_id']) {
            $santri = Santri::where('nis', $validated['nis'])->first();
            if ($santri) {
                $validated['santri_id'] = $santri->id;
            }
        }

        $surat->update($validated);

        return redirect()->route('admin.surat.list')->with('success', 'Surat berhasil diupdate');
    }

    public function deleteSurat($id)
    {
        $surat = \App\Models\surat::findOrFail($id);

        // Delete associated file if exists
        if ($surat->file_surat) {
            \Storage::delete('public/surats/' . $surat->file_surat);
        }

        $surat->delete();

        return redirect()->route('admin.surat.list')->with('success', 'Surat berhasil dihapus');
    }

    public function getSuratJson($id)
    {
        $surat = \App\Models\surat::with('santri')->findOrFail($id);
        return response()->json($surat);
    }

    public function searchSantriByNis(Request $request)
    {
        $nis = $request->input('nis');
        $santri = Santri::where('nis', $nis)->first();

        if ($santri) {
            return response()->json([
                'success' => true,
                'santri' => $santri
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Santri tidak ditemukan'
        ]);
    }

    public function generateNomorSurat(Request $request)
    {
        $jenis_surat = $request->input('jenis_surat');
        $currentYear = date('Y');

        // Get the last surat number for this year
        $lastSurat = \App\Models\surat::where('nomor_surat', 'like', "%/{$currentYear}")
            ->orderBy('nomor_surat', 'desc')
            ->first();

        if ($lastSurat) {
            // Extract number from last surat
            preg_match('/(\d+)\//', $lastSurat->nomor_surat, $matches);
            $lastNumber = intval($matches[1]);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        $nomorSurat = sprintf("%03d/SURAT/%s", $newNumber, $currentYear);

        return response()->json([
            'nomor_surat' => $nomorSurat
        ]);
    }

    /**
     * Show template management page
     */
    public function templateSurat()
    {
        $templates = template_surat::orderBy('created_at', 'desc')->get();
        return view('admin.templatesurat', compact('templates'));
    }

    /**
     * Store new template with file upload
     */
    public function storeTemplate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_template' => 'required|string|max:255',
            'jenis_surat' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'template_file' => 'required|file|mimes:doc,docx,pdf,txt,html|max:10240', // 10MB max
            'content_html' => 'nullable|string',
        ]);

        $path = '/template/'. $request->jenis_surat;
        $file = $request->template_file;
        $ext = $request->template_file->getClientOriginalExtension();
        $filename = $path . '_' . time() . '.' . $ext;

        $link = Storage::disk('public')->putFileAs($path, $file, $filename);

        $template = new template_surat();
        $template->nama_template = $filename ;
        $template->jenis_surat = $request->jenis_surat ;
        $template->deskripsi = $request->deskripsi ;
        $template->file_name = $filename ;
        $template->save() ;

        return redirect()->back()->with('success', 'berhasil disimpan');

    }

    /**
     * Update existing template
     */
    public function updateTemplate(Request $request, $id)
    {
        $template = template_surat::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_template' => 'required|string|max:255',
            'jenis_surat' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'template_file' => 'nullable|file|mimes:doc,docx,pdf,txt,html|max:10240',
            'content_html' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $template->update([
                'nama_template' => $request->nama_template,
                'jenis_surat' => $request->jenis_surat,
                'deskripsi' => $request->deskripsi,
                'content_html' => $request->content_html,
                'updated_by' => auth()->user()->name ?? 'Admin',
            ]);

            // Update file if new one is uploaded
            if ($request->hasFile('template_file')) {
                $template->storeFile($request->file('template_file'));
            }

            return response()->json([
                'success' => true,
                'message' => 'Template berhasil diperbarui',
                'template' => $template
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui template: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Soft delete template (arsip, tidak hapus file fisik)
     */
    public function deleteTemplate($id)
    {
        try {
            $template = template_surat::findOrFail($id);

            // Soft delete template record (file tetap ada sebagai backup)
            $template->delete();

            return response()->json([
                'success' => true,
                'message' => 'Template berhasil diarsipkan (soft delete)'
            ]);

        } catch (\Exception $e) {
            \Log::error('Gagal mengarsipkan template: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengarsipkan template: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download template file
     */
    public function downloadTemplate($id)
    {
        try {
            $template = template_surat::findOrFail($id);

            if (!$template->file_path || !Storage::disk('private')->exists($template->file_path)) {
                abort(404, 'File tidak ditemukan');
            }

            return Storage::disk('private')->download($template->file_path, $template->file_name);

        } catch (\Exception $e) {
            abort(404, 'File tidak dapat diunduh');
        }
    }

    /**
     * Get templates for dropdown
     */
    public function getTemplates(Request $request)
    {
        $jenisSurat = $request->get('jenis_surat');

        $query = template_surat::active();

        if ($jenisSurat) {
            $query->byJenisSurat($jenisSurat);
        }

        $templates = $query->get(['id', 'nama_template', 'jenis_surat', 'content_html']);

        return response()->json([
            'success' => true,
            'templates' => $templates
        ]);
    }

    /**
     * Get template content by ID
     */
    public function getTemplateContent($id)
    {
        try {
            $template = template_surat::findOrFail($id);

            return response()->json([
                'success' => true,
                'template' => $template,
                'content_html' => $template->content_html
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Template tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Toggle template active status
     */
    public function toggleTemplateStatus($id)
    {
        try {
            $template = template_surat::withTrashed()->findOrFail($id);
            $newIsActive = !$template->is_active;
            $template->is_active = $newIsActive;
            $template->updated_by = auth()->user()->name ?? 'Admin';
            $template->save();

            // Update semua surat yang menggunakan template ini
            $newStatus = $newIsActive ? 'Aktif' : 'Tidak Aktif';
            \App\Models\surat::where('template_surat', $template->nama_template)
                ->update(['status' => $newStatus]);

            return response()->json([
                'success' => true,
                'message' => 'Status template dan semua surat terkait berhasil diperbarui',
                'is_active' => $template->is_active
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status template'
            ], 500);
        }
    }

    public function getTemplatesList()
    {
        try {
            $templates = TemplateSurat::where('is_active', true)
                ->select('id', 'nama_template', 'jenis_surat', 'content_html')
                ->orderBy('nama_template')
                ->get();

            return response()->json([
                'success' => true,
                'templates' => $templates
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat daftar template: ' . $e->getMessage()
            ], 500);
        }
    }

    public function templates(Request $request)
    {
        $query = $request->input('q');
        $jenis_surat = $request->input('jenis_surat');
        $status = $request->input('status');

        // Hanya ambil data yang belum di-soft delete
        $templates = template_surat::whereNull('deleted_at');

        if ($query) {
            $templates = $templates->where(function($qobj) use ($query) {
                $qobj->where('nama_template', 'like', "%{$query}%")
                  ->orWhere('jenis_surat', 'like', "%{$query}%")
                  ->orWhere('deskripsi', 'like', "%{$query}%");
            });
        }

        if ($jenis_surat) {
            $templates = $templates->where('jenis_surat', $jenis_surat);
        }

        if ($status !== null && $status !== '') {
            // Convert string status to boolean
            $isActive = $status == 1 || $status === '1' || $status === true;
            $templates = $templates->where('is_active', $isActive);
        }

        $templates = $templates->orderBy('created_at', 'desc')->get();

        return view('admin.templatesurat', compact('templates'));
    }

    /**
     * Membaca isi file template (txt, html, docx, pdf) dan mengembalikan HTML ke frontend
     */
    public function readTemplateFile(Request $request)
    {
        $request->validate([
            'template_file' => 'required|file|mimes:txt,html,docx,pdf'
        ]);

        $file = $request->file('template_file');
        $ext = $file->getClientOriginalExtension();
        $content = '';

        if ($ext === 'txt' || $ext === 'html') {
            $content = file_get_contents($file->getRealPath());
            if ($ext === 'txt') {
                $content = nl2br(e($content));
            }
        } elseif ($ext === 'docx') {
            try {
                $phpWord = IOFactory::load($file->getRealPath());
                $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');
                ob_start();
                $htmlWriter->save('php://output');
                $content = ob_get_clean();
            } catch (\Exception $e) {
                $content = '<p style="color:red">Gagal membaca file DOCX: ' . $e->getMessage() . '</p>';
            }
        } elseif ($ext === 'pdf') {
            try {
                $parser = new Parser();
                $pdf = $parser->parseFile($file->getRealPath());
                $text = $pdf->getText();
                $content = nl2br(e($text));
            } catch (\Exception $e) {
                $content = '<p style="color:red">Gagal membaca file PDF: ' . $e->getMessage() . '</p>';
            }
        }

        return response()->json(['content_html' => $content]);
    }
}
