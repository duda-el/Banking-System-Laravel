<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class GetTransactionsByUserController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        $accountIds = $user->accounts->pluck('id');

        $transactions = Transaction::whereIn('account_id', $accountIds)->get();

        return response()->json([
            'success' => true,
            'transactions' => $transactions,
        ]);
    }
}
