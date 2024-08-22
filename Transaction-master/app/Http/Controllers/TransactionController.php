<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Models\Transaction; 

class TransactionController extends Controller
{
    public function index():JsonResponse
    {
        $transactions = Transaction::get();

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'transactions' => $transactions
        ], 200);
        
    }
}
