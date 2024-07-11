<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Item;
use App\Models\ItemUnit;
use App\Models\Transaction;
use App\Models\TransactionDetail;
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
        $items = Item::all();
        $itemUnits = ItemUnit::all();
        return view("transaction", [
            "accounts" => $accounts,
            "items" => $items,
            "itemUnits" => $itemUnits
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
            $transaction->date = Carbon::parse($transaction->created_at)->format('d M Y');
            return $transaction;
        });
        return response()->json([
            "transactions" => $formattedTransactions,
            "status" => 200
        ]);
    }

    public function findById($id){
        $transaction = Transaction::with([
            "company",
            "account",
            "status"
        ])->whereNull("deleted_at")->find($id);
        $transaction->date = Carbon::parse($transaction->created_at)->format('d M Y');
        return response()->json([
            "transaction" => $transaction,
            "status" => 200,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string',
            'account_id' => 'required|uuid',
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
            'created_at' => $request->input('date'),
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
        $validator = Validator::make($request->all(), [
            'code' => 'required|string',
            'account_id' => 'required|uuid',
            'note' => 'nullable|string',
            'date' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $transaction = Transaction::find($id);
        if (!$transaction) {
            return response()->json([
                'error' => 'Transaction not found',
                'status' => 404
            ], 404);
        }

        $transaction->code = $request->input('code');
        $transaction->account_id = $request->input('account_id');
        $transaction->note = $request->input('note');
        $transaction->updated_at = $request->input('date', Carbon::now()); // Update the date if provided, otherwise use the current date

        $transaction->save();

        return response()->json([
            'message' => 'Success update transaction',
            'status' => 200
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function softDelete(string $id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'error' => 'Transaction not found',
                'status' => 404
            ], 404);
        }

        $transaction->delete();

        return response()->json([
            'message' => 'Success delete transaction',
            'status' => 200
        ]);
    }
    public function findAllDetailById($id)
    {
        try {
            $transactionDetails = TransactionDetail::with(['itemUnit', 'item'])
                ->where('transaction_id', $id)
                ->get();
            return response()->json([
                'transaction_details' => $transactionDetails,
                'status' => 200,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch transaction details.',
                'status' => 500,
            ], 500);
        }
    }
}
