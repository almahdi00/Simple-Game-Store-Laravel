@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Edit Game</h1>
    <form action="{{ route('admin.games.update', $game) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block mb-2 font-semibold text-gray-700">Name</label>
            <input type="text" name="name" value="{{ old('name', $game->name) }}" class="w-full p-2 border rounded" required>
            @error('name') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-2 font-semibold text-gray-700">Description</label>
            <textarea name="description" class="w-full p-2 border rounded" required rows="4">{{ old('description', $game->description) }}</textarea>
            @error('description') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-2 font-semibold text-gray-700">Developer</label>
            <input type="text" name="developer" value="{{ old('developer', $game->developer) }}" class="w-full p-2 border rounded" required>
            @error('developer') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-2 font-semibold text-gray-700">Price</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $game->price) }}" class="w-full p-2 border rounded" required>
            @error('price') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-2 font-semibold text-gray-700">Category</label>
            <select name="category_id" class="w-full p-2 border rounded" required>
                <option value="">-- Select Category --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $game->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-2 font-semibold text-gray-700">Game ZIP File <span class="text-gray-500">(Leave blank to keep existing)</span></label>
            <input type="file" name="file_zip" class="w-full p-2 border rounded" accept=".zip">
            @error('file_zip') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-2 font-semibold text-gray-700">Thumbnail <span class="text-gray-500">(Leave blank to keep existing)</span></label>
            <img src="{{ asset('storage/' . $game->thumbnail) }}" alt="Thumbnail" class="w-32 h-32 object-cover rounded mb-2 border">
            <input type="file" name="thumbnail" class="w-full p-2 border rounded" accept="image/*">
            @error('thumbnail') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 transition text-white px-6 py-2 rounded font-semibold">
            Update
        </button>
    </form>
</div>
@endsection
