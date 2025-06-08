<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $query = Kategori::query();

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('nama_kategori', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        $kategoris = $query->oldest()->paginate(5)->withQueryString();
        return view('kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|min:3|unique:kategoris,nama_kategori',
            'keterangan' => 'nullable|max:255'
        ]);

        Kategori::create($validated);
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kategori' => [
                'required',
                'min:3',
                Rule::unique('kategoris', 'nama_kategori')->ignore($id),
            ],
            'keterangan' => 'nullable|max:255'
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update($validated);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id): RedirectResponse
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
