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
        $query = Kode::with('kategori');

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                  ->orWhere('nama_kode', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        $kodes = $query->oldest()->paginate(5)->withQueryString();
        return view('kode.index', compact('kodes'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('kode.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|unique:kodes,kode',
            'nama_kode' => 'required|min:3',
            'keterangan' => 'nullable',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        Kode::create($validated);
        return redirect()->route('kode.index')->with('success', 'Kode berhasil ditambahkan.');
    }

    public function edit(Kode $kode)
    {
        $kategoris = Kategori::all();
        return view('kode.edit', compact('kode', 'kategoris'));
    }

    public function update(Request $request, Kode $kode)
    {
        $validated = $request->validate([
            'kode' => ['required', Rule::unique('kodes', 'kode')->ignore($kode->id)],
            'nama_kode' => 'required|min:3',
            'keterangan' => 'nullable',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        $kode->update($validated);
        return redirect()->route('kode.index')->with('success', 'Kode berhasil diperbarui.');
    }

    public function destroy(Kode $kode)
    {
        $kode->delete();
        return redirect()->route('kode.index')->with('success', 'Kode berhasil dihapus.');
    }
}
