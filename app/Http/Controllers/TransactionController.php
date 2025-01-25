<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Account;
use App\Notifications\TransactionNotification;
use Illuminate\Http\Request;



class TransactionController extends Controller
{
    public function index(Request $request)
    {
        // Fetch all transactions for the authenticated user
        $transactions = Transaction::whereIn('account_id', $request->user()->accounts->pluck('id'))->get();
        return response()->json($transactions);
    }

    public function deposit(Request $request)
    {
    $request->validate([
        'account_id' => 'required|exists:accounts,id',
        'amount' => 'required|numeric|min:1',
    ]);

    // Ensure the authenticated user owns the account
    $account = Account::where('id', $request->account_id)
        ->where('user_id', $request->user()->id)
        ->first();

    if (!$account) {
        return response()->json(['message' => 'Unauthorized access to this account'], 403);
    }

    // Perform the deposit
    $account->balance += $request->amount;
    $account->save();

    // Log the transaction
    $transaction = $account->transactions()->create([
        'type' => 'deposit',
        'amount' => $request->amount,
        'description' => 'Deposit made',
    ]);

    return response()->json($transaction, 201);
    }


    public function withdraw(Request $request)
    {
    $request->validate([
        'account_id' => 'required|exists:accounts,id',
        'amount' => 'required|numeric|min:1',
    ]);

    $account = Account::where('id', $request->account_id)
        ->where('user_id', $request->user()->id)
        ->first();

    if (!$account) {
        return response()->json(['message' => 'Unauthorized access to this account'], 403);
    }

    if ($account->balance < $request->amount) {
        return response()->json(['message' => 'Insufficient balance'], 400);
    }

    $account->balance -= $request->amount;
    $account->save();

    $transaction = $account->transactions()->create([
        'type' => 'withdrawal',
        'amount' => $request->amount,
        'description' => 'Withdrawal made',
    ]);

    return response()->json($transaction, 201);
    }


    public function transfer(Request $request)
    {
    $request->validate([
        'from_account_id' => 'required|exists:accounts,id',
        'to_account_id' => 'required|exists:accounts,id|different:from_account_id',
        'amount' => 'required|numeric|min:1',
    ]);


    $fromAccount = Account::where('id', $request->from_account_id)
        ->where('user_id', $request->user()->id) 
        ->first();

    if (!$fromAccount) {
        return response()->json(['message' => 'Unauthorized access to this account'], 403);
    }


    $toAccount = Account::findOrFail($request->to_account_id);

    if ($fromAccount->balance < $request->amount) {
        return response()->json(['message' => 'Insufficient balance'], 400);
    }


    $fromAccount->balance -= $request->amount;
    $toAccount->balance += $request->amount;

    $fromAccount->save();
    $toAccount->save();


    $fromAccount->transactions()->create([
        'type' => 'transfer',
        'amount' => $request->amount,
        'description' => 'Transfer to account ' . $toAccount->account_number,
    ]);

    $toAccount->transactions()->create([
        'type' => 'transfer',
        'amount' => $request->amount,
        'description' => 'Transfer from account ' . $fromAccount->account_number,
    ]);

    // Notify the sender
    $fromAccount->user->notify(new TransactionNotification('You sent $' . $request->amount . ' to account ' . $toAccount->account_number));

    // Notify the recipient
    $toAccount->user->notify(new TransactionNotification('You received $' . $request->amount . ' from account ' . $fromAccount->account_number));


    return response()->json(['message' => 'Transfer successful'], 201);
    }

}

