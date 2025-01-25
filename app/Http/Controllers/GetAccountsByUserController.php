<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GetAccountsByUserController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        $accounts = $user->accounts()->get();

        return response()->json([
            'success' => true,
            'accounts' => $accounts,
        ]);
    }
}
