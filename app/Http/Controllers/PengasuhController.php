<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Surat;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PengasuhController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dasbord() {

        $totalSurat = Surat::count(); // hitung semua data surat
        $suratDisetujui = Surat::where('status', 'disetujui')->count(); // hitung surat yang disetujui
        $suratMenunggu = Surat::where('status', 'pending')->count(); // hitung surat yang menunggu
        $santri = Santri::count(); // ambil semua data santri

        return view('pengasuh.dasbordpengasuh', [
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
        return view('pengasuh.datasantri', [
            'santris' => $santris,
            'search' => $query
        ]);
    }
    public function detailSantri($id)
    {
        $santriDetail = \App\Models\santri::findOrFail($id);
        $santris = \App\Models\santri::all();
        return view('pengasuh.datasantri', compact('santris', 'santriDetail'));
    }

    public function updatepengasuhSurat(Request $request, $id)
    {
        $surat = \App\Models\surat::findOrFail($id);

        $request->validate([
            'nomor_surat' => 'required',
            'jenis_surat' => 'required',
            'tanggal_surat' => 'required|date',
            'tanggal_kembali' => 'nullable|date',
            'alasan' => 'nullable|string',
            'diagnosa' => 'nullable|string',
            'content' => 'nullable|string',
            'status' => 'required',
            'santri_id' => 'required|exists:santris,id'
        ]);

        $surat->update($request->only([
            'nomor_surat', 'jenis_surat', 'tanggal_surat',
            'tanggal_kembali', 'alasan', 'diagnosa',
            'content', 'status', 'santri_id'
        ]));

        return response()->json(['message' => 'Surat berhasil diperbarui']);
    }

    public function detailpengasuhSurat($id)
    {
        $surat = \App\Models\surat::with('santri')->findOrFail($id);
        return view('pengasuh.editSurat', compact('surat'));
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
        return view('pengasuh.datasurat', [
            'santris' => $santris,
            'search' => $query
        ]);
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

}
