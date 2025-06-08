<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;

class JurusanController extends Controller
{
    public function index(Request $request)
    {
        $query = Jurusan::query();

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('nama_jurusan', 'like', "%{$search}%")
                  ->orWhere('kode_jurusan', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        $jurusans = $query->oldest()->paginate(5)->withQueryString();
        return view('jurusan.index', compact('jurusans'));
    }

    public function create()
    {
        return view('jurusan.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_jurusan' => 'required|min:2|unique:jurusans,kode_jurusan',
            'nama_jurusan' => 'required|min:3',
            'keterangan' => 'nullable|max:255'
        ]);

        Jurusan::create($validated);
        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        return view('jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            'kode_jurusan' => [
                'required',
                'min:2',
                Rule::unique('jurusans', 'kode_jurusan')->ignore($id),
            ],
            'nama_jurusan' => 'required|min:3',
            'keterangan' => 'nullable|max:255'
        ]);

        $jurusan = Jurusan::findOrFail($id);
        $jurusan->update($validated);

        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil diperbarui.');
    }

    public function destroy($id): RedirectResponse
    {
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->delete();

        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil dihapus.');
    }
}
