@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Upload Game Baru</h1>
    <form action="{{ route('games.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label class="block mb-2 font-semibold text-gray-700">Nama Game</label>
            <input type="text" name="name" class="w-full p-2 border rounded" required value="{{ old('name') }}">
            @error('name') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-2 font-semibold text-gray-700">Deskripsi</label>
            <textarea name="description" class="w-full p-2 border rounded" rows="4" required>{{ old('description') }}</textarea>
            @error('description') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-2 font-semibold text-gray-700">Developer</label>
            <input type="text" name="developer" class="w-full p-2 border rounded" required value="{{ old('developer') }}">
            @error('developer') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-2 font-semibold text-gray-700">Harga</label>
            <input type="number" step="0.01" name="price" class="w-full p-2 border rounded" required value="{{ old('price') }}">
            @error('price') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-2 font-semibold text-gray-700">Kategori</label>
            <select name="category_id" class="w-full p-2 border rounded" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-2 font-semibold text-gray-700">Thumbnail</label>
            <input type="file" name="thumbnail" class="w-full p-2 border rounded" accept="image/*">
            @error('thumbnail') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-2 font-semibold text-gray-700">File ZIP Game</label>
            <input type="file" name="file_zip" class="w-full p-2 border rounded" accept=".zip">
            @error('file_zip') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 transition text-white px-6 py-2 rounded font-semibold">
            Upload Game
        </button>
    </form>
</div>
@endsection
