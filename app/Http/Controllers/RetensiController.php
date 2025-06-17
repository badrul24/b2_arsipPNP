<?php

namespace App\Http\Controllers;

use App\Models\Retensi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Diperlukan untuk Rule::unique dan Rule::in

class RetensiController extends Controller
{
    public function index(Request $request)
    {
        $query = Retensi::query();

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('kode_retensi', 'like', "%{$search}%")
                  ->orWhere('nama_retensi', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        $retensis = $query->oldest()->paginate(5)->withQueryString();
        return view('retensi.index', compact('retensis'));
    }

    public function create()
    {
        return view('retensi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_retensi'  => 'required|max:10|unique:retensis,kode_retensi',
            'nama_retensi'  => 'required|max:100',
            'tahun_aktif'   => 'required|integer|min:0',
            'tahun_inaktif' => 'required|integer|min:0',
            'nasib_akhir'   => ['required', Rule::in(['Musnah', 'Permanen', 'Dinilai Kembali'])],
            'keterangan'    => 'nullable|string', 
        ]);

        Retensi::create($validated);
        return redirect()->route('retensi.index')->with('success', 'Retensi berhasil ditambahkan.');
    }

    public function show(Retensi $retensi)
    {
        //
    }

    public function edit(Retensi $retensi)
    {
        return view('retensi.edit', compact('retensi'));
    }

    public function update(Request $request, Retensi $retensi)
    {
        $validated = $request->validate([
            'kode_retensi'  => ['required', 'max:10', Rule::unique('retensis', 'kode_retensi')->ignore($retensi->id)],
            'nama_retensi'  => 'required|max:100',
            'tahun_aktif'   => 'required|integer|min:0',
            'tahun_inaktif' => 'required|integer|min:0',
            'nasib_akhir'   => ['required', Rule::in(['Musnah', 'Permanen', 'Dinilai Kembali'])],
            'keterangan'    => 'nullable|string',
        ]);

        $retensi->update($validated);
        return redirect()->route('retensi.index')->with('success', 'Retensi berhasil diperbarui.');
    }

    public function destroy(Retensi $retensi)
    {
        $retensi->delete();
        return redirect()->route('retensi.index')->with('success', 'Retensi berhasil dihapus.');
    }
}
