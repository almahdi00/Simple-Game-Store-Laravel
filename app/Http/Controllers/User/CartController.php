<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Game;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::where('user_id', Auth::id())->with('game')->get();
        return view('cart.index', compact('carts'));
    }

    public function add(Request $request, Game $game)
    {
        // Cegah user membeli game buatan sendiri
        if ($game->user_id == Auth::id()) {
            return redirect()->back()->with('error', 'Kamu tidak bisa membeli game buatanmu sendiri.');
        }

        $existing = Cart::where('user_id', Auth::id())
            ->where('game_id', $game->id)
            ->where('status', 'pending')
            ->first();

        if (!$existing) {
            Cart::create([
                'user_id' => Auth::id(),
                'game_id' => $game->id,
                'quantity' => 1,
                'status' => 'pending',
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Game berhasil ditambahkan ke keranjang.');
    }

    public function checkout()
    {
        $carts = Cart::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->with('game')
            ->get();

        foreach ($carts as $cart) {
            // Cegah checkout jika game dibuat oleh user sendiri
            if ($cart->game->user_id == Auth::id()) {
                continue; // Lewati game buatan sendiri
            }

            Transaction::create([
                'user_id' => Auth::id(),
                'game_id' => $cart->game_id,
                'status' => 'pending',
            ]);

            $cart->status = 'checked_out';
            $cart->save();
        }

        return redirect()->route('profile.index')->with('success', 'Checkout selesai. Menunggu persetujuan admin.');
    }

    public function destroy($cartId)
    {
        $cart = Cart::findOrFail($cartId);

        // Pastikan hanya owner cart yang bisa hapus
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cart->delete();

        return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    public function checkoutItem($id)
    {
        $cart = Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->with('game')
            ->firstOrFail();

        if ($cart->game->user_id == Auth::id()) {
            return back()->with('error', 'Tidak bisa checkout game buatan sendiri.');
        }

        Transaction::create([
            'user_id' => Auth::id(),
            'game_id' => $cart->game_id,
            'status' => 'pending',
        ]);

        $cart->status = 'checked_out';
        $cart->save();

        return back()->with('success', 'Game berhasil di-checkout.');
    }
}