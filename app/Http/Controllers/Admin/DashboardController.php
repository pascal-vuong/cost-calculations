<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        $userCount = $users->count();

        return view('admin.dashboard', compact('users', 'userCount'));
    }
}
