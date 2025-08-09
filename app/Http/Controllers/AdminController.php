<?php

namespace App\Http\Controllers;

use App\Models\Recipient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        $totalRecipients = Recipient::count();
        $belumRegisterCount = Recipient::where('status', 'belum_register')->count();
        $sudahRegisterCount = Recipient::where('status', 'sudah_register')->count();
        $sudahMenerimaCount = Recipient::where('status', 'sudah_menerima')->count();
        
        $uniformCount = Recipient::where('uniform_received', true)->count();
        $shoesCount = Recipient::where('shoes_received', true)->count();
        $bagCount = Recipient::where('bag_received', true)->count();

        $recentRegistrations = Recipient::where('status', '!=', 'belum_register')
            ->with('user')
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalRecipients',
            'belumRegisterCount', 
            'sudahRegisterCount',
            'sudahMenerimaCount',
            'uniformCount',
            'shoesCount',
            'bagCount',
            'recentRegistrations'
        ));
    }

    public function registerQr(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|exists:recipients,qr_code'
        ]);

        $recipient = Recipient::where('qr_code', $request->qr_code)->first();

        if ($recipient->status !== 'belum_register') {
            return response()->json([
                'success' => false,
                'message' => 'QR Code sudah terdaftar atau sudah menerima bantuan'
            ]);
        }

        $recipient->update(['status' => 'sudah_register']);

        return response()->json([
            'success' => true,
            'message' => 'QR Code berhasil diregistrasi',
            'recipient' => $recipient
        ]);
    }

    public function scanRegister()
    {
        return view('admin.scan-register');
    }
}