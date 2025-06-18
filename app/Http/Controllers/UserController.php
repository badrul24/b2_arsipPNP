<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jurusan;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $currentUser = Auth::user();
        if (!$currentUser || !$currentUser->isAdmin()) {
            abort(403, 'Anda tidak memiliki izin untuk melihat daftar pengguna.');
        }

        $users = User::with(['jurusan', 'divisi'])->latest()->paginate(5);
        return view('user.index', compact('users'));
    }

    public function create()
    {
        $currentUser = Auth::user();

        if (!$currentUser || !$currentUser->isAdmin()) {
            abort(403, 'Anda tidak memiliki izin untuk membuat pengguna baru.');
        }

        $jurusans = Jurusan::all();
        $divisis = Divisi::all();

        return view('user.create', compact('jurusans', 'divisis'));
    }

    public function store(Request $request)
    {
        $currentUser = Auth::user();

        if (!$currentUser || !$currentUser->isAdmin()) {
            abort(403, 'Anda tidak memiliki izin untuk menyimpan pengguna baru.');
        }

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:8|confirmed',
            'role'      => 'required|in:admin,operator,pimpinan,kepala_lembaga,kepala_bidang,sekretaris',
            'jurusan_id' => 'nullable|required_if:role,operator|exists:jurusans,id',
            'divisi_id' => 'nullable|required_if:role,kepala_lembaga,kepala_bidang,sekretaris|exists:divisis,id',
        ], [
            'jurusan_id.required_if' => 'Jurusan wajib dipilih jika peran adalah Operator.',
            'jurusan_id.exists'      => 'Jurusan yang dipilih tidak valid.',
            'divisi_id.required_if'  => 'Divisi wajib dipilih jika peran adalah Kepala Lembaga, Kepala Bidang, atau Sekretaris.',
            'divisi_id.exists'       => 'Divisi yang dipilih tidak valid.',
        ]);

        User::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'password'  => Hash::make($validated['password']),
            'role'      => $validated['role'],
            'jurusan_id' => $validated['role'] === 'operator' ? $validated['jurusan_id'] : null,
            'divisi_id'  => in_array($validated['role'], ['kepala_lembaga', 'kepala_bidang', 'sekretaris']) ? $validated['divisi_id'] : null,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:8|confirmed',
        ]);

        User::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'password'  => Hash::make($validated['password']),
            'role'      => 'operator',
            'jurusan_id' => null,
            'divisi_id'  => null,
            'email_verified_at' => now()
        ]);

        return redirect()->route('login')->with('success', 'Akun Anda berhasil didaftarkan. Silakan login.');
    }

    public function edit(User $user)
    {
        $currentUser = Auth::user();

        if (!$currentUser || !$currentUser->isAdmin()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit pengguna.');
        }

        $jurusans = Jurusan::all();
        $divisis = Divisi::all();

        return view('user.edit', compact('user', 'jurusans', 'divisis'));
    }

    public function update(Request $request, User $user)
    {
        $currentUser = Auth::user();

        if (!$currentUser || !$currentUser->isAdmin()) {
            abort(403, 'Anda tidak memiliki izin untuk memperbarui pengguna.');
        }

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password'  => 'nullable|min:8|confirmed',
            'role'      => 'required|in:admin,operator,pimpinan,kepala_lembaga,kepala_bidang,sekretaris',
            'jurusan_id' => 'nullable|required_if:role,operator|exists:jurusans,id',
            'divisi_id' => 'nullable|required_if:role,kepala_lembaga,kepala_bidang,sekretaris|exists:divisis,id',
        ], [
            'jurusan_id.required_if' => 'Jurusan wajib dipilih jika peran adalah Operator.',
            'jurusan_id.exists'      => 'Jurusan yang dipilih tidak valid.',
            'divisi_id.required_if'  => 'Divisi wajib dipilih jika peran adalah Kepala Lembaga, Kepala Bidang, atau Sekretaris.',
            'divisi_id.exists'       => 'Divisi yang dipilih tidak valid.',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['jurusan_id'] = $validated['role'] === 'operator' ? $validated['jurusan_id'] : null;
        $validated['divisi_id']  = in_array($validated['role'], ['kepala_lembaga', 'kepala_bidang', 'sekretaris']) ? $validated['divisi_id'] : null;

        $user->update($validated);
        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $currentUser = Auth::user();

        if (!$currentUser || !$currentUser->isAdmin()) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus pengguna.');
        }

        if ($currentUser->id === $user->id) {
            return back()->withErrors(['error' => 'Anda tidak bisa menghapus akun Anda sendiri.']);
        }

        $user->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
    }
}
