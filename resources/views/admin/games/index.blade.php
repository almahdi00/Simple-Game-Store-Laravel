@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Manage Games</h1>

    <div class="flex flex-wrap justify-between items-center mb-6 gap-3">
        <a href="{{ route('admin.games.create') }}" 
           class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-md transition">
           Add Game
        </a>

        <form action="{{ route('admin.games.index') }}" method="GET" class="flex flex-grow max-w-md">
            <input type="text" name="search" placeholder="Search games..."
                   value="{{ request('search') }}"
                   class="flex-grow p-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-green-500" />
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 rounded-r-md transition">
                Search
            </button>
        </form>
    </div>

    <div class="overflow-x-auto border rounded-md">
        <table class="w-full text-left min-w-[600px]">
            <thead class="bg-gray-100 border-b border-gray-300">
                <tr>
                    <th class="p-3 font-semibold text-gray-700">Name</th>
                    <th class="p-3 font-semibold text-gray-700">Category</th>
                    <th class="p-3 font-semibold text-gray-700">Price</th>
                    <th class="p-3 font-semibold text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($games as $game)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="p-3">{{ $game->name }}</td>
                        <td class="p-3">{{ $game->category->name }}</td>
                        <td class="p-3">Rp {{ number_format($game->price, 2) }}</td>
                        <td class="p-3 space-x-3">
                            <a href="{{ route('admin.games.edit', $game) }}"
                               class="text-blue-600 hover:text-blue-800 font-semibold">
                               Edit
                            </a>
                            <form action="{{ route('admin.games.destroy', $game) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Are you sure you want to delete this game?')"
                                        class="text-red-600 hover:text-red-800 font-semibold">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                @if($games->isEmpty())
                <tr>
                    <td colspan="4" class="p-4 text-center text-gray-500">No games found.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $games->links() }}
    </div>
</div>
@endsection
