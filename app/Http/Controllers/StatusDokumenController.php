<?php

namespace App\Http\Controllers;

use App\Models\StatusDokumen;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StatusDokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = StatusDokumen::query();

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('nama_status', 'like', "%{$search}%")
                  ->orWhere('kode_status', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $statusDokumens = $query->oldest()->paginate(5)->withQueryString();
        return view('statusDokumen.index', compact('statusDokumens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('statusDokumen.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_status' => 'required|min:3',
            'kode_status' => 'required|unique:status_dokumens,kode_status',
            'deskripsi' => 'nullable',
            'warna' => 'nullable',
            'is_active' => 'boolean'
        ]);

        StatusDokumen::create($validated);
        return redirect()->route('statusDokumen.index')->with('success', 'Status dokumen berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(StatusDokumen $statusDokumen)
    {
        return view('statusDokumen.show', compact('statusDokumen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StatusDokumen $statusDokumen)
    {
        return view('statusDokumen.edit', compact('statusDokumen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StatusDokumen $statusDokumen)
    {
        $validated = $request->validate([
            'nama_status' => 'required|min:3',
            'kode_status' => ['required', Rule::unique('status_dokumens', 'kode_status')->ignore($statusDokumen->id)],
            'deskripsi' => 'nullable',
            'warna' => 'nullable',
            'is_active' => 'boolean'
        ]);

        $statusDokumen->update($validated);
        return redirect()->route('statusDokumen.index')->with('success', 'Status dokumen berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StatusDokumen $statusDokumen)
    {
        $statusDokumen->delete();
        return redirect()->route('statusDokumen.index')->with('success', 'Status dokumen berhasil dihapus.');
    }
}
