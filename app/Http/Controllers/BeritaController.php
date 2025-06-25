<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $beritas = Berita::with(['user', 'kategori'])
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('judul_berita', 'like', "%{$search}%")
                      ->orWhere('isi_berita', 'like', "%{$search}%")
                      ->orWhereHas('kategori', fn($q) => $q->where('nama_kategori', 'like', "%{$search}%"))
                      ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%"));
                });
            })
            ->oldest()
            ->paginate(5)
            ->withQueryString();

        return view('berita.index', compact('beritas'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('berita.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateBerita($request, true);
        $validated['user_id'] = Auth::id();

        Berita::create($validated);
        return redirect()->route('berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function show(Berita $berita)
    {
        return view('berita.show', compact('berita'));
    }

    public function edit(Berita $berita)
    {
        $kategoris = Kategori::all();
        return view('berita.edit', compact('berita', 'kategoris'));
    }

    public function update(Request $request, Berita $berita)
    {
        $validated = $this->validateBerita($request, false, $berita);
        $berita->update($validated);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        $this->deleteGambar($berita->gambar);
        $berita->delete();

        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus.');
    }

    // ----------------------------------
    // 🔧 PRIVATE METHODS
    // ----------------------------------

    private function validateBerita(Request $request, bool $isStore = true, Berita $berita = null): array
    {
        $rules = [
            'judul_berita' => 'required|min:3',
            'kategori_id' => 'required|exists:kategoris,id',
            'isi_berita'   => 'required',
            'gambar'       => ($isStore ? 'required' : 'nullable') . '|image|mimes:jpeg,png,jpg|max:2048',
        ];

        $validated = $request->validate($rules);

        if ($request->hasFile('gambar')) {
            if (!$isStore) {
                $this->deleteGambar($berita->gambar ?? null);
            }

            $gambar = $request->file('gambar');
            $namaFile = time() . '_' . $gambar->getClientOriginalName();
            $gambar->move(public_path('images'), $namaFile);
            $validated['gambar'] = 'images/' . $namaFile;
        } elseif (!$isStore && $berita) {
            $validated['gambar'] = $berita->gambar;
        }

        return $validated;
    }

    private function deleteGambar(?string $path): void
    {
        if ($path && file_exists(public_path($path))) {
            unlink(public_path($path));
        }
    }
}
