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
            $query->where(function ($q) use ($search) {
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
            'role' => [
                'required',
                'string',
                Rule::in(['admin', 'operator', 'pimpinan']),
                Rule::unique('hak_akses', 'role')->withoutTrashed()
            ],
            'can_view' => 'nullable|boolean',
            'can_create' => 'nullable|boolean',
            'can_edit' => 'nullable|boolean',
            'can_delete' => 'nullable|boolean',
            'can_approve' => 'nullable|boolean',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Pastikan semua field boolean memiliki nilai eksplisit
        $validated = array_merge([
            'can_view' => $request->boolean('can_view'),
            'can_create' => $request->boolean('can_create'),
            'can_edit' => $request->boolean('can_edit'),
            'can_delete' => $request->boolean('can_delete'),
            'can_approve' => $request->boolean('can_approve'),
        ], $validated);

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
        $hakAkses = HakAkses::findOrFail($id);

        $validated = $request->validate([
            'role' => [
                'required',
                'string',
                Rule::in(['admin', 'operator', 'pimpinan']),
                Rule::unique('hak_akses', 'role')->ignore($hakAkses->id)->withoutTrashed()
            ],
            'can_view' => 'nullable|boolean',
            'can_create' => 'nullable|boolean',
            'can_edit' => 'nullable|boolean',
            'can_delete' => 'nullable|boolean',
            'can_approve' => 'nullable|boolean',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $validated = array_merge([
            'can_view' => $request->boolean('can_view'),
            'can_create' => $request->boolean('can_create'),
            'can_edit' => $request->boolean('can_edit'),
            'can_delete' => $request->boolean('can_delete'),
            'can_approve' => $request->boolean('can_approve'),
        ], $validated);

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
