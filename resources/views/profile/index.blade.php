@extends('layouts.app')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-[#003b61]">Your Profile</h1>

<h2 class="text-2xl font-semibold mb-4">Purchase History</h2>

@if ($transactions->count() > 0)
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
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($transactions as $transaction)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                    {{ $transaction->game->name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-gray-700">
                    Rp {{ number_format($transaction->game->price, 2) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    <span class="inline-block px-3 py-1 rounded-full text-sm
                        {{ $transaction->status === 'approved' ? 'bg-green-100 text-green-800' :
                           ($transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-600') }}">
                        {{ ucfirst($transaction->status) }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center space-x-3">
                    @if ($transaction->status == 'approved')
                    <a href="{{ route('games.play', $transaction->game) }}"
                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded transition text-sm">
                        Play
                    </a>
                    <a href="{{ asset('storage/' . $transaction->game->file_zip) }}" download
                        class="inline-block bg-gray-600 hover:bg-gray-700 text-white px-4 py-1 rounded transition text-sm">
                        Download
                    </a>
                    <a href="{{ route('transactions.print', $transaction->id) }}" target="_blank"
                        class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-1 rounded transition text-sm">
                        Print
                    </a>
                    @else
                    <span class="text-gray-500 italic text-sm">No actions available</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Pagination --}}
<div class="mt-6">
    {{ $transactions->links() }}
</div>
@else
<p class="text-center text-gray-600 mt-12">You have no purchase history yet.</p>
@endif
@endsection