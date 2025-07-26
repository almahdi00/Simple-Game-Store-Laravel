@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Manage Transactions</h1>

    <table class="w-full border-collapse border border-gray-300 shadow-sm">
        <thead>
            <tr class="bg-gray-200 text-gray-700">
                <th class="p-3 border border-gray-300 text-left">User</th>
                <th class="p-3 border border-gray-300 text-left">Game</th>
                <th class="p-3 border border-gray-300 text-left">Status</th>
                <th class="p-3 border border-gray-300 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
            <tr class="hover:bg-gray-50">
                <td class="p-3 border border-gray-300">{{ $transaction->user->name }}</td>
                <td class="p-3 border border-gray-300">{{ $transaction->game->name }}</td>
                <td class="p-3 border border-gray-300 font-semibold">{{ ucfirst($transaction->status) }}</td>
                <td class="p-3 border border-gray-300 space-x-3">
                    @if ($transaction->status == 'pending')
                        <form action="{{ route('admin.transactions.approve', $transaction) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded transition">
                                Approve
                            </button>
                        </form>
                        <form action="{{ route('admin.transactions.reject', $transaction) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded transition">
                                Reject
                            </button>
                        </form>
                    @else
                        <span class="text-gray-500 italic">No actions</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-6">
        {{ $transactions->links() }}
    </div>
</div>
@endsection
