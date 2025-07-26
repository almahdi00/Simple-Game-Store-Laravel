@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-extrabold text-gray-900 mb-6">Games</h1>

    {{-- Search & Filter Bar --}}
    <form action="{{ route('games.index') }}" method="GET" class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-3 sm:space-y-0 mb-8">
        <div class="relative w-full sm:w-2/3">
            <input
                type="text"
                name="search"
                placeholder="Search games..."
                value="{{ request('search') }}"
                class="w-full rounded-lg border border-gray-300 py-3 px-4 pr-12 text-gray-900 placeholder-gray-400 focus:border-green-500 focus:ring-1 focus:ring-green-500" />
            <svg class="absolute right-4 top-3.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0a7 7 0 1110-10 7 7 0 01-10 10z" />
            </svg>
        </div>

        <select
            name="category"
            class="w-full sm:w-1/4 rounded-lg border border-gray-300 py-3 px-4 text-gray-900 focus:border-green-500 focus:ring-1 focus:ring-green-500">
            <option value="">All Categories</option>
            @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
            @endforeach
        </select>

        <button
            type="submit"
            class="w-full sm:w-auto bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg py-3 px-6 transition">
            Search
        </button>
    </form>

    {{-- Games Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($games as $game)
        <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition p-4 flex flex-col">
            <a href="{{ route('games.show', $game) }}" class="block overflow-hidden rounded-md mb-4">
                <img src="{{ asset('storage/' . $game->thumbnail) }}" alt="{{ $game->name }}" class="w-full h-40 object-cover transform hover:scale-105 transition duration-300 ease-in-out" />
            </a>

            <div class="flex-grow">
                <a href="{{ route('games.show', $game) }}" class="text-lg font-semibold text-gray-900 hover:text-green-600 transition">
                    {{ $game->name }}
                </a>
                <p class="text-green-600 font-bold text-md mt-1 mb-3">Rp {{ number_format($game->price, 0, ',', '.') }}</p>
                <p class="text-gray-600 text-sm line-clamp-3">
                    {{ \Illuminate\Support\Str::limit(strip_tags($game->description), 100, '...') }}
                </p>
            </div>

            @auth
            @if ($game->user_id !== auth()->id())
            <form action="{{ route('cart.add', $game) }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white rounded-lg py-2 font-semibold transition">
                    Add to Cart
                </button>
            </form>
            @else
            <p class="mt-4 text-red-500 text-sm italic">Ini adalah game buatanmu sendiri</p>
            @endif
            @endauth

        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-10">
        {{ $games->links() }}
    </div>
</div>
@endsection