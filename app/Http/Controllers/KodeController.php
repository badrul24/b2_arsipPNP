<?php

namespace App\Http\Controllers;

use App\Models\Kode;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KodeController extends Controller
{
    public function index(Request $request)
    {
        $kodes = Kode::with('kategori')
            ->when($request->search, fn($q, $search) =>
                $q->where('kode', 'like', "%{$search}%")
                  ->orWhere('nama_kode', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%")
            )
            ->oldest()
            ->paginate(5)
            ->withQueryString();

        return view('kode.index', compact('kodes'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('kode.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        Kode::create($this->validateKode($request));
        return redirect()->route('kode.index')->with('success', 'Kode berhasil ditambahkan.');
    }

    public function edit(Kode $kode)
    {
        $kategoris = Kategori::all();
        return view('kode.edit', compact('kode', 'kategoris'));
    }

    public function update(Request $request, Kode $kode)
    {
        $kode->update($this->validateKode($request, $kode->id));
        return redirect()->route('kode.index')->with('success', 'Kode berhasil diperbarui.');
    }

    public function destroy(Kode $kode)
    {
        $kode->delete();
        return redirect()->route('kode.index')->with('success', 'Kode berhasil dihapus.');
    }

    protected function validateKode(Request $request, $ignoreId = null): array
    {
        return $request->validate([
            'kode'        => ['required', Rule::unique('kodes', 'kode')->ignore($ignoreId)],
            'nama_kode'   => 'required|min:3',
            'keterangan'  => 'nullable',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);
    }
}
