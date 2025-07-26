@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Admin Dashboard</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <a href="{{ route('admin.games.index') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold p-6 rounded-lg shadow-md text-center transition">
           Manage Games
        </a>

        <a href="{{ route('admin.categories.index') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold p-6 rounded-lg shadow-md text-center transition">
           Manage Categories
        </a>

        <a href="{{ route('admin.transactions.index') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold p-6 rounded-lg shadow-md text-center transition">
           Manage Transactions
        </a>
    </div>
</div>
@endsection
