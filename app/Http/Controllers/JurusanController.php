<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JurusanController extends Controller
{
    public function index(Request $request)
    {
        $jurusans = Jurusan::query()
            ->when($request->search, fn ($query, $search) => $query->where('nama_jurusan', 'like', "%{$search}%")
                ->orWhere('kode_jurusan', 'like', "%{$search}%")
                ->orWhere('keterangan', 'like', "%{$search}%")
            )
            ->oldest()
            ->paginate(5)
            ->withQueryString();

        return view('jurusan.index', compact('jurusans'));
    }

    public function create()
    {
        return view('jurusan.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Jurusan::create($this->validateJurusan($request));

        return redirect()
            ->route('jurusan.index')
            ->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function edit(Jurusan $jurusan)
    {
        return view('jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, Jurusan $jurusan): RedirectResponse
    {
        $jurusan->update($this->validateJurusan($request, $jurusan->id));

        return redirect()
            ->route('jurusan.index')
            ->with('success', 'Jurusan berhasil diperbarui.');
    }

    public function destroy(Jurusan $jurusan): RedirectResponse
    {
        $jurusan->delete();

        return redirect()
            ->route('jurusan.index')
            ->with('success', 'Jurusan berhasil dihapus.');
    }

    protected function validateJurusan(Request $request, $ignoreId = null): array
    {
        return $request->validate([
            'kode_jurusan' => [
                'required',
                'min:2',
                Rule::unique('jurusans', 'kode_jurusan')->ignore($ignoreId),
            ],
            'nama_jurusan' => 'required|min:3',
            'keterangan' => 'nullable|max:255',
        ]);
    }
}
