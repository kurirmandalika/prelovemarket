<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::query()
            ->with('sellerProfile')
            ->withCount(['products', 'purchases', 'sales'])
            ->latest()
            ->paginate(12);

        return view('admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'role' => ['required', Rule::in(['admin', 'user'])],
        ]);

        if ($user->is($request->user()) && $data['role'] !== 'admin') {
            return back()->with('error', 'Admin yang sedang login tidak bisa menurunkan role dirinya sendiri.');
        }

        $user->update($data);

        return back()->with('success', 'Role user berhasil diperbarui.');
    }
}
