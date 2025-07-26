@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded shadow max-w-4xl mx-auto">
    <img src="{{ asset('storage/' . $game->thumbnail) }}" alt="{{ $game->name }}" class="w-full h-64 object-cover rounded mb-6">
    
    <h1 class="text-3xl font-bold mb-3 text-[#003b61]">{{ $game->name }}</h1>
    
    <div class="flex flex-wrap text-gray-700 mb-4 space-x-4">
        <p><span class="font-semibold">Developer:</span> {{ $game->developer }}</p>
        <p><span class="font-semibold">Category:</span> {{ $game->category->name }}</p>
        <p><span class="font-semibold">Price:</span> Rp {{ number_format($game->price, 2) }}</p>
    </div>
    
    <p class="mb-6 text-gray-700 leading-relaxed">{{ $game->description }}</p>
    
    <div class="flex flex-col sm:flex-row sm:space-x-4 space-y-3 sm:space-y-0">
        <form action="{{ route('cart.add', $game) }}" method="POST" class="flex-1">
            @csrf
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded w-full transition">
                Add to Cart
            </button>
        </form>

        @if (auth()->check() && \App\Models\Transaction::where('user_id', auth()->id())->where('game_id', $game->id)->where('status', 'approved')->exists())
        <a href="{{ route('games.play', $game) }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded text-center transition">
            Play Game
        </a>
        <a href="{{ asset('storage/' . $game->file_zip) }}" download class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded text-center transition">
            Download
        </a>
        @endif
    </div>
</div>
@endsection
