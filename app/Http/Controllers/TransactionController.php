<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = Account::all();
        return view("transaction", [
            "accounts" => $accounts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'account_id' => 'nullable|uuid',
            'note' => 'nullable|string',
        ]);
        $username = session('username');
        $user = User::where("username", $username)->first();

        $code = $request->input('code') === '<<Auto>>' ? str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT) : $request->input('code');

        Transaction::create([
            'company_id' => $user->company_id,
            'code' => $code,
            'account_id' => $request->input('account_id'),
            'note' => $request->input('note'),
        ]);

        return response()->json([
            'message' => "Success create transaction",
            'status' => 200
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
