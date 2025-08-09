<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $recipient = $user->recipient;
        
        if (!$recipient) {
            return redirect()->route('login')->with('error', 'Data penerima tidak ditemukan');
        }

        return view('user.dashboard', compact('recipient'));
    }
}