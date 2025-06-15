<?php

namespace App\Http\Controllers;

use App\Models\StatusDokumen;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StatusDokumenController extends Controller
{
    public function index(Request $request)
    {
        $query = StatusDokumen::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_status', 'like', "%{$search}%")
                    ->orWhere('nama_status', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $statusDokumens = $query->paginate(10);

        return view('statusDokumen.index', compact('statusDokumens'));
    }

    public function create()
    {
        return view('statusDokumen.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_status' => 'required|string|max:255|unique:status_dokumens',
            'nama_status' => 'required|string|max:255',
            'deskripsi' => 'nullable|string'
        ]);

        StatusDokumen::create($validated);

        return redirect()->route('statusDokumen.index')
            ->with('success', 'Status dokumen berhasil ditambahkan');
    }

    // public function show(StatusDokumen $statusDokumen)
    // {
    //     return view('statusDokumen.show', compact('statusDokumen'));
    // }

    public function edit(StatusDokumen $statusDokumen)
    {
        return view('statusDokumen.edit', compact('statusDokumen'));
    }

    public function update(Request $request, StatusDokumen $statusDokumen)
    {
        $validated = $request->validate([
            'kode_status' => 'required|string|max:255|unique:status_dokumens,kode_status,' . $statusDokumen->id,
            'nama_status' => 'required|string|max:255',
            'deskripsi' => 'nullable|string'
        ]);

        $statusDokumen->update($validated);

        return redirect()->route('statusDokumen.index')
            ->with('success', 'Status dokumen berhasil diperbarui');
    }

    public function destroy(StatusDokumen $statusDokumen)
    {
        try {
            $statusDokumen->delete();
            return redirect()->route('statusDokumen.index')
                ->with('success', 'Status dokumen berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('statusDokumen.index')
                ->with('error', 'Status dokumen tidak dapat dihapus karena masih digunakan');
        }
    }
}
