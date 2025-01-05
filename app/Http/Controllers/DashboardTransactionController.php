<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardTransactionController extends Controller
{
    public function index()
    {
        $buyTransactions = TransactionDetail::with(['transaction.user','product.galleries'])
                            ->whereHas('transaction', function($transaction){
                                $transaction->where('users_id', Auth::user()->id);
                            })->get();
        
        return view('pages.dashboard-transactions',[
            'buyTransactions' => $buyTransactions,
            'transaction_count' => $buyTransactions->count()
        ]);
    }

    public function details(Request $request, $id)
    {
        Log::info('Fetching transaction details for ID: ' . $id);
        $transaction = TransactionDetail::with(['transaction.user','product.galleries'])
                            ->findOrFail($id);
        Log::info('Transaction details fetched: ', $transaction->toArray());
        return view('pages.dashboard-transactions-details',[
            'transaction' => $transaction,
            'shipping_status' => $transaction->shipping_status,
            'resi' => $transaction->resi,
            'code' => $transaction->code
        ]);
    }
}
