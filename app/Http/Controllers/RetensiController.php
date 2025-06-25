<?php

namespace App\Http\Controllers;

use App\Models\Retensi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RetensiController extends Controller
{
    public function index(Request $request)
    {
        $retensis = Retensi::query()
            ->when($request->search, fn($q, $search) =>
                $q->where('kode_retensi', 'like', "%{$search}%")
                  ->orWhere('nama_retensi', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%")
            )
            ->oldest()
            ->paginate(5)
            ->withQueryString();

        return view('retensi.index', compact('retensis'));
    }

    public function create()
    {
        return view('retensi.create');
    }

    public function store(Request $request)
    {
        Retensi::create($this->validateRetensi($request));
        return redirect()->route('retensi.index')->with('success', 'Retensi berhasil ditambahkan.');
    }

    public function edit(Retensi $retensi)
    {
        return view('retensi.edit', compact('retensi'));
    }

    public function update(Request $request, Retensi $retensi)
    {
        $retensi->update($this->validateRetensi($request, $retensi->id));
        return redirect()->route('retensi.index')->with('success', 'Retensi berhasil diperbarui.');
    }

    public function destroy(Retensi $retensi)
    {
        $retensi->delete();
        return redirect()->route('retensi.index')->with('success', 'Retensi berhasil dihapus.');
    }

    protected function validateRetensi(Request $request, $ignoreId = null): array
    {
        return $request->validate([
            'kode_retensi'  => ['required', 'max:10', Rule::unique('retensis', 'kode_retensi')->ignore($ignoreId)],
            'nama_retensi'  => 'required|max:100',
            'tahun_aktif'   => 'required|integer|min:0',
            'tahun_inaktif' => 'required|integer|min:0',
            'nasib_akhir'   => ['required', Rule::in(['Musnah', 'Permanen', 'Dinilai Kembali'])],
            'keterangan'    => 'nullable|string',
        ]);
    }
}
