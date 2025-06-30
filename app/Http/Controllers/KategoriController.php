<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $kategoris = Kategori::query()
            ->when($request->search, fn ($q, $search) => $q->where('nama_kategori', 'like', "%{$search}%")
                ->orWhere('keterangan', 'like', "%{$search}%")
            )
            ->oldest()
            ->paginate(5)
            ->withQueryString();

        return view('kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Kategori::create($this->validateKategori($request));

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori): RedirectResponse
    {
        $kategori->update($this->validateKategori($request, $kategori->id));

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori): RedirectResponse
    {
        $kategori->delete();

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }

    protected function validateKategori(Request $request, $ignoreId = null): array
    {
        return $request->validate([
            'nama_kategori' => [
                'required',
                'min:3',
                Rule::unique('kategoris', 'nama_kategori')->ignore($ignoreId),
            ],
            'keterangan' => 'nullable|max:255',
        ]);
    }
}
