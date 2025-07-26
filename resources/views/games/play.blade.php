@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Play {{ $game->name }}</h1>

<div class="relative bg-white p-6 rounded shadow">
    <iframe 
        id="gameFrame" 
        src="{{ asset('storage/' . $game->index_path) }}" 
        class="w-full h-[600px] rounded" 
        frameborder="0" 
        allowfullscreen
        allow="fullscreen"
    ></iframe>

    <button 
        id="fullscreenBtn" 
        class="absolute top-4 right-4 bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition"
        type="button"
        title="Toggle Fullscreen"
    >
        ⛶ Fullscreen
    </button>
</div>

<script>
    const btn = document.getElementById('fullscreenBtn');
    const iframe = document.getElementById('gameFrame');

    btn.addEventListener('click', () => {
        if (!document.fullscreenElement) {
            // request fullscreen for iframe container
            iframe.requestFullscreen ? iframe.requestFullscreen() :
            iframe.webkitRequestFullscreen ? iframe.webkitRequestFullscreen() :
            iframe.msRequestFullscreen && iframe.msRequestFullscreen();
        } else {
            document.exitFullscreen();
        }
    });
</script>
@endsection
