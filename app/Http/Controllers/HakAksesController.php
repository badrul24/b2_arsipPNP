<?php

namespace App\Http\Controllers;

use App\Models\HakAkses;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;

class HakAksesController extends Controller
{
    public function index(Request $request)
    {
        $query = HakAkses::query();

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('role', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        $hakAkses = $query->oldest()->paginate(5)->withQueryString();
        return view('hakAkses.index', compact('hakAkses'));
    }

    public function create()
    {
        return view('hakAkses.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'role' => 'required|string|in:admin,operator,pimpinan',
            'can_view' => 'required|boolean',
            'can_create' => 'required|boolean',
            'can_edit' => 'required|boolean',
            'can_delete' => 'required|boolean',
            'can_approve' => 'required|boolean',
            'keterangan' => 'nullable|max:255'
        ]);

        HakAkses::create($validated);
        return redirect()->route('hak-akses.index')->with('success', 'Hak akses berhasil ditambahkan.');
    }

    public function show($id)
    {
        $hakAkses = HakAkses::find($id);

        if (!$hakAkses) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hak akses tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $hakAkses
        ]);
    }

    public function edit($id)
    {
        $hakAkses = HakAkses::findOrFail($id);
        return view('hakAkses.edit', compact('hakAkses'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            'role' => 'required|string|in:admin,operator,pimpinan',
            'can_view' => 'required|boolean',
            'can_create' => 'required|boolean',
            'can_edit' => 'required|boolean',
            'can_delete' => 'required|boolean',
            'can_approve' => 'required|boolean',
            'keterangan' => 'nullable|max:255'
        ]);

        $hakAkses = HakAkses::findOrFail($id);
        $hakAkses->update($validated);

        return redirect()->route('hak-akses.index')->with('success', 'Hak akses berhasil diperbarui.');
    }

    public function destroy($id): RedirectResponse
    {
        $hakAkses = HakAkses::findOrFail($id);
        $hakAkses->delete();

        return redirect()->route('hak-akses.index')->with('success', 'Hak akses berhasil dihapus.');
    }
}
