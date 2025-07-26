<?php

namespace App\Http\Controllers\User;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class TransactionController
{
    public function printSingle(Transaction $transaction)
{
    if ($transaction->user_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }

    $transaction->load('game'); // pastikan relasi diload

    $pdf = Pdf::loadView('transactions.print', compact('transaction'));
    return $pdf->download('Transaksi-' . $transaction->id . '.pdf');
}

}
