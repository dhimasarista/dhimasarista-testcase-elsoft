<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
    public function findAll()
    {
        $transactions = Transaction::with([
            "company",
            "account",
            "status"
        ])->whereNull("deleted_at")->get();
        $formattedTransactions = $transactions->map(function ($transaction, $index) {
            $transaction->number = $index + 1;
            $transaction->date = Carbon::parse($transaction->update_at)->format('d M Y');
            return $transaction;
        });
        return response()->json([
            "transactions" => $formattedTransactions,
            "status" => 200
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string',
            'account_id' => 'nullable|uuid',
            'note' => 'nullable|string',
            'date' => 'nullable|string'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => 400
            ], 400);
        }
        $username = session('username');
        $user = User::where("username", $username)->first();

        $code = $request->input('code') === '<<Auto>>' ? str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT) : $request->input('code');

        Transaction::create([
            'company_id' => $user->company_id,
            'code' => $code,
            'account_id' => $request->input('account_id'),
            'note' => $request->input('note'),
            'updated_at' => $request->input('date'),
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
