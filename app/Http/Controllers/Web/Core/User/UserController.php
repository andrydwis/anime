<?php

namespace App\Http\Controllers\Web\Core\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $data = [
            'users' => User::with('roles')->orderBy('created_at', 'desc')->paginate(10)->withQueryString(),
        ];

        return view('core.user.index', $data);
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        session()->flash('success', 'Pengguna berhasil dihapus.');

        return redirect()->back();
    }
}
