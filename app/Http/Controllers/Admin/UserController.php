<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AuditHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::whereIn('role', [UserRole::Admin, UserRole::SuperAdmin])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $user = User::create($data);

        AuditHelper::log('CREATE', 'User', $user->id, ['name' => $user->name, 'role' => $user->role->value]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Admin berhasil ditambahkan.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        // Remove password if empty (don't update)
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        AuditHelper::log('UPDATE', 'User', $user->id, ['name' => $user->name, 'role' => $user->role->value]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Admin berhasil diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        // Prevent deleting self
        if ($user->id === auth('admin')->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        AuditHelper::log('DELETE', 'User', $user->id, ['name' => $user->name]);

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Admin berhasil dihapus.');
    }
}
