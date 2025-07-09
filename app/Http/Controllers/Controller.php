<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class Controller
{
    //

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
        $santri = \App\Models\Santri::create($validated);
       return redirect()->back()->with('success', 'Santri berhasil ditambahkan');
    }
}
