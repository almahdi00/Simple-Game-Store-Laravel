@extends('layouts.app')

@section('content')
<div class="text-center py-20">
    <h1 class="text-4xl font-bold text-[#003b61] mb-4">Selamat Datang di GameStore!</h1>
    <p class="text-lg text-gray-600 mb-6">Temukan dan mainkan berbagai game seru langsung di browser kamu.</p>
    <a href="{{ route('games.index') }}" class="bg-[#003b61] text-white px-6 py-3 rounded-md text-lg hover:bg-blue-800 transition">
        Mulai Jelajahi Game
    </a>
</div>
@endsection
