<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        // Jika tidak, tampilkan halaman login
        return view("login");
    }
    public function post(Request $request)
    {
        try {
            // Menerima username dan password dari request body
            $credentials = $request->only('username', 'password');

            // Mencoba memeriksa kredensial
            if (Auth::attempt($credentials)) { // Jika cocok
                $user = Auth::user();

                // Memeriksa apakah akun user aktif
                if ($user->deleted_at != null) {
                    // Jika tidak aktif, response dengan status 400
                    return response()->json(['message' => 'Your account is inactive'], 400);
                }

                // Jika aktif, tambahkan sesi ke user
                $request->session()->put('username', $user->username);
                $request->session()->put('user_id', $user->id);
                $request->session()->put('name', $user->name);
                return response()->json(['message' => 'Login successful'], 200);
            } else { // Jika tidak cocok
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
        } catch (\Throwable $th) {
            // Tangani exception jika terjadi
            return response()->json(['message' => 'An error occurred while processing your request'], 500);
        }
    }

    public function destroy()
    {
        // $request->session()->forget('username');
        Auth::logout(); // Logout user dari Auth
        return redirect('/login');
    }
}
