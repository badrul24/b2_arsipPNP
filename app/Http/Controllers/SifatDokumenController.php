<?php

namespace App\Http\Controllers;

use App\Models\SifatDokumen;
use Illuminate\Http\Request;

class SifatDokumenController extends Controller
{
    public function index(Request $request)
    {
        $query = SifatDokumen::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_sifat', 'like', "%{$search}%")
                    ->orWhere('nama_sifat', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        $sifatDokumens = $query->paginate(10);

        return view('sifatDokumen.index', compact('sifatDokumens'));
    }

    public function create()
    {
        return view('sifatDokumen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_sifat' => 'required|string|max:10|unique:sifat_dokumens',
            'nama_sifat' => 'required|string|max:100',
            'keterangan' => 'nullable|string'
        ]);

        SifatDokumen::create($request->all());

        return redirect()->route('sifat-dokumen.index')
            ->with('success', 'Sifat dokumen berhasil ditambahkan');
    }

    public function edit(SifatDokumen $sifatDokumen)
    {
        return view('sifatDokumen.edit', compact('sifatDokumen'));
    }

    public function update(Request $request, SifatDokumen $sifatDokumen)
    {
        $request->validate([
            'kode_sifat' => 'required|string|max:10|unique:sifat_dokumens,kode_sifat,' . $sifatDokumen->id,
            'nama_sifat' => 'required|string|max:100',
            'keterangan' => 'nullable|string'
        ]);

        $sifatDokumen->update($request->all());

        return redirect()->route('sifat-dokumen.index')
            ->with('success', 'Sifat dokumen berhasil diperbarui');
    }

    public function destroy(SifatDokumen $sifatDokumen)
    {
        try {
            $sifatDokumen->delete();
            return redirect()->route('sifat-dokumen.index')
                ->with('success', 'Sifat dokumen berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('sifat-dokumen.index')
                ->with('error', 'Sifat dokumen tidak dapat dihapus karena masih digunakan');
        }
    }
} 