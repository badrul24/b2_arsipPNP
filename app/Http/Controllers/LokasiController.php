<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LokasiController extends Controller
{
    public function index(Request $request)
    {
        $lokasis = Lokasi::query()
            ->when($request->search, fn ($q, $search) => $q->where('kode_lokasi', 'like', "%{$search}%")
                ->orWhere('nama_lokasi', 'like', "%{$search}%")
                ->orWhere('keterangan', 'like', "%{$search}%")
            )
            ->oldest()
            ->paginate(5)
            ->withQueryString();

        return view('lokasi.index', compact('lokasis'));
    }

    public function create()
    {
        return view('lokasi.create');
    }

    public function store(Request $request)
    {
        Lokasi::create($this->validateLokasi($request));

        return redirect()->route('lokasi.index')->with('success', 'Lokasi berhasil ditambahkan.');
    }

    public function edit(Lokasi $lokasi)
    {
        return view('lokasi.edit', compact('lokasi'));
    }

    public function update(Request $request, Lokasi $lokasi)
    {
        $lokasi->update($this->validateLokasi($request, $lokasi->id));

        return redirect()->route('lokasi.index')->with('success', 'Lokasi berhasil diperbarui.');
    }

    public function destroy(Lokasi $lokasi)
    {
        $lokasi->delete();

        return redirect()->route('lokasi.index')->with('success', 'Lokasi berhasil dihapus.');
    }

    protected function validateLokasi(Request $request, $ignoreId = null): array
    {
        return $request->validate([
            'kode_lokasi' => ['required', Rule::unique('lokasis', 'kode_lokasi')->ignore($ignoreId)],
            'nama_lokasi' => 'required|min:3',
            'keterangan' => 'nullable',
        ]);
    }
}
