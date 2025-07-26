@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">My Games</h2>

<a href="{{ route('games.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
    + Upload Game Baru
</a>

@if($games->count())
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($games as $game)
            <div class="border rounded p-4 shadow">
                @if($game->thumbnail)
                    <img src="{{ asset('storage/' . $game->thumbnail) }}" class="mb-2 w-full h-40 object-cover">
                @endif
                <h3 class="font-semibold text-lg">{{ $game->name }}</h3>
                <p class="text-sm text-gray-600">{{ $game->developer }}</p>
                <div class="mt-2 flex gap-2">
                    <a href="{{ route('games.edit', $game) }}" class="text-blue-500">Edit</a>
                    <form action="{{ route('games.destroy', $game) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus game ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500">Hapus</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $games->links() }}
    </div>
@else
    <p class="text-gray-500">Kamu belum mengunggah game apapun.</p>
@endif
@endsection
