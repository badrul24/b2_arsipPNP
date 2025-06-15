<?php

namespace App\Http\Controllers;

use App\Models\Retensi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RetensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Retensi::query();

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('kode_retensi', 'like', "%{$search}%")
                  ->orWhere('nama_retensi', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        $retensis = $query->oldest()->paginate(5)->withQueryString();
        return view('retensi.index', compact('retensis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('retensi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_retensi' => 'required|max:10|unique:retensis,kode_retensi',
            'nama_retensi' => 'required|max:100',
            'tahun_aktif' => 'required|integer|min:1',
            'tahun_inaktif' => 'required|integer|min:1',
            'keterangan' => 'nullable',
        ]);

        Retensi::create($validated);
        return redirect()->route('retensi.index')->with('success', 'Retensi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Retensi $retensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Retensi $retensi)
    {
        return view('retensi.edit', compact('retensi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Retensi $retensi)
    {
        $validated = $request->validate([
            'kode_retensi' => ['required', 'max:10', Rule::unique('retensis', 'kode_retensi')->ignore($retensi->id)],
            'nama_retensi' => 'required|max:100',
            'tahun_aktif' => 'required|integer|min:1',
            'tahun_inaktif' => 'required|integer|min:1',
            'keterangan' => 'nullable',
        ]);

        $retensi->update($validated);
        return redirect()->route('retensi.index')->with('success', 'Retensi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Retensi $retensi)
    {
        $retensi->delete();
        return redirect()->route('retensi.index')->with('success', 'Retensi berhasil dihapus.');
    }
}
