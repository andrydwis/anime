<?php

namespace App\Http\Controllers\Web\Core\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $data = [
            'users' => User::with('roles')->orderBy('created_at', 'desc')->paginate()->withQueryString(),
        ];

        return view('core.user.index', $data);
    }
}
