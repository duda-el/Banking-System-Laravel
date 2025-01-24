<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $accounts = $request->user()->accounts;
        return response()->json($accounts);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:savings,checking',
        ]);


        $account = $request->user()->accounts()->create([
            'account_number' => uniqid(),
            'type' => $request->type,
            'balance' => 0,
        ]);

        return response()->json($account, 201);
    }
}

