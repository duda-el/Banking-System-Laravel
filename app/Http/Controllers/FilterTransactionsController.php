<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class FilterTransactionsController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'type' => 'nullable|string|in:deposit,withdrawal,transfer',
        ]);

        $user = $request->user();


        $accountIds = $user->accounts->pluck('id');


        $query = Transaction::whereIn('account_id', $accountIds);

        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        $transactions = $query->get();

        return response()->json([
            'success' => true,
            'transactions' => $transactions,
        ]);
    }
}
