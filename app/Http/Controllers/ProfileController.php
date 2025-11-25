<?php
namespace App\Http\Controllers;

class ProfileController extends Controller
{
    // UserController.php
    public function index()
    {
        $users = User::with('profile')->paginate(10);
        return view('users.index', compact('users'));
    }
}
