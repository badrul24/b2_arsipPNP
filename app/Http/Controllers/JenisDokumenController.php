<?php

namespace App\Http\Controllers;

use App\Models\JenisDokumen;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JenisDokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JenisDokumen::query();

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('kode_jenis', 'like', "%{$search}%")
                  ->orWhere('nama_jenis', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        $jenisDokumens = $query->oldest()->paginate(5)->withQueryString();
        return view('jenisDokumen.index', compact('jenisDokumens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jenisDokumen.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_jenis' => 'required|unique:jenis_dokumens,kode_jenis',
            'nama_jenis' => 'required|min:3',
            'keterangan' => 'nullable',
        ]);

        JenisDokumen::create($validated);
        return redirect()->route('jenis-dokumen.index')->with('success', 'Jenis dokumen berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisDokumen $jenisDokumen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisDokumen $jenisDokumen)
    {
        return view('jenisDokumen.edit', compact('jenisDokumen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisDokumen $jenisDokumen)
    {
        $validated = $request->validate([
            'kode_jenis' => ['required', Rule::unique('jenis_dokumens', 'kode_jenis')->ignore($jenisDokumen->id)],
            'nama_jenis' => 'required|min:3',
            'keterangan' => 'nullable',
        ]);

        $jenisDokumen->update($validated);
        return redirect()->route('jenis-dokumen.index')->with('success', 'Jenis dokumen berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisDokumen $jenisDokumen)
    {
        $jenisDokumen->delete();
        return redirect()->route('jenis-dokumen.index')->with('success', 'Jenis dokumen berhasil dihapus.');
    }
}
