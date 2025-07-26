<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['user', 'game'])->latest()->paginate(10);
        return view('admin.transactions.index', compact('transactions'));
    }



    public function approve(Transaction $transaction)
    {
        $transaction->update(['status' => 'approved']);
        $cart = \App\Models\Cart::where('user_id', $transaction->user_id)
            ->where('game_id', $transaction->game_id)
            ->first();
        if ($cart) {
            $cart->update(['status' => 'approved']);
        }
        return redirect()->route('admin.transactions.index')->with('success', 'Transaction approved.');
    }

    public function reject(Transaction $transaction)
    {
        $transaction->update(['status' => 'rejected']);
        $cart = \App\Models\Cart::where('user_id', $transaction->user_id)
            ->where('game_id', $transaction->game_id)
            ->first();
        if ($cart) {
            $cart->update(['status' => 'rejected']);
        }
        return redirect()->route('admin.transactions.index')->with('success', 'Transaction rejected.');
    }
}
