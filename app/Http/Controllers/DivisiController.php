<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DivisiController extends Controller
{
    public function index(Request $request)
    {
        $divisis = Divisi::query()
            ->when($request->search, fn($query, $search) =>
                $query->where('kode_divisi', 'like', "%{$search}%")
                      ->orWhere('nama_divisi', 'like', "%{$search}%")
                      ->orWhere('keterangan', 'like', "%{$search}%")
            )
            ->oldest()
            ->paginate(5)
            ->withQueryString();

        return view('divisi.index', compact('divisis'));
    }

    public function create()
    {
        return view('divisi.create');
    }

    public function store(Request $request)
    {
        Divisi::create($this->validateDivisi($request));

        return redirect()
            ->route('divisi.index')
            ->with('success', 'Divisi berhasil ditambahkan.');
    }

    public function show(Divisi $divisi)
    {
        return view('divisi.show', compact('divisi'));
    }

    public function edit(Divisi $divisi)
    {
        return view('divisi.edit', compact('divisi'));
    }

    public function update(Request $request, Divisi $divisi)
    {
        $divisi->update($this->validateDivisi($request, $divisi->id));

        return redirect()
            ->route('divisi.index')
            ->with('success', 'Divisi berhasil diperbarui.');
    }

    public function destroy(Divisi $divisi)
    {
        $divisi->delete();

        return redirect()
            ->route('divisi.index')
            ->with('success', 'Divisi berhasil dihapus.');
    }

    protected function validateDivisi(Request $request, $ignoreId = null): array
    {
        return $request->validate([
            'kode_divisi' => [
                'required',
                'min:2',
                'max:10',
                Rule::unique('divisis')->ignore($ignoreId),
            ],
            'nama_divisi' => 'required|min:3',
            'keterangan' => 'nullable',
        ]);
    }
}
