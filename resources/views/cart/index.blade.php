@extends('layouts.app')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-[#003b61]">Your Cart</h1>

@if ($carts->count() > 0)
<div class="overflow-x-auto">
    <table class="min-w-full border border-gray-300 rounded-lg divide-y divide-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Game</th>
                <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Price</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Status</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
            @foreach ($carts as $cart)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-medium">{{ $cart->game->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-gray-700">Rp {{ number_format($cart->game->price, 2) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    <span class="inline-block px-3 py-1 rounded-full text-sm
                        {{ $cart->status === 'approved' ? 'bg-green-100 text-green-800' : 
                            ($cart->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-600') }}">
                        {{ ucfirst($cart->status) }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                    @if ($cart->status !== 'approved')
                    <form action="{{ route('cart.checkoutItem', $cart->id) }}" method="POST">
                    @csrf
                        <button type="submit">Checkout</button>
                    </form>

                    <form action="{{ route('cart.destroy', $cart->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure to remove this item?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                            Remove
                        </button>
                    </form>
                    @else
                    <span class="text-green-700 font-semibold">Purchased</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<p class="text-gray-600 text-center mt-12">Your cart is empty.</p>
@endif

@endsection