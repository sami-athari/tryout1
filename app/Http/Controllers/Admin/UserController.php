<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
      $users = User::where('role', '!=', 'admin')->paginate(10); // asumsikan ada kolom 'role'
        $total = User::count(); // Total jumlah user

        return view('admin.users.index', compact('users', 'total'));
    }
}
