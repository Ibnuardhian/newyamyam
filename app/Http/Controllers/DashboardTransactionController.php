<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardTransactionController extends Controller
{
    public function index(Request $request)
    {
        $keyword = strtolower($request->input('keyword'));
        $buyTransactions = TransactionDetail::with(['transaction.user','product.galleries'])
                            ->whereHas('transaction', function($transaction){
                                $transaction->where('users_id', Auth::user()->id);
                            })
                            ->when($keyword, function($query, $keyword) {
                                return $query->whereHas('transaction', function($transaction) use ($keyword) {
                                    $transaction->whereRaw('UPPER(code) like ?', ["%".strtoupper($keyword)."%"]);
                                })->orWhereHas('product', function($product) use ($keyword) {
                                    $product->where('name', 'like', "%{$keyword}%");
                                });
                            })
                            ->get();
        
        return view('pages.dashboard-transactions',[
            'buyTransactions' => $buyTransactions,
            'transaction_count' => $buyTransactions->count(),
            'keyword' => $keyword
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
            'code' => $transaction->transaction ? $transaction->transaction->code : null
        ]);
    }
}
