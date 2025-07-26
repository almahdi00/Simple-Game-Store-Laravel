@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Add New Game</h1>
    <form action="{{ route('admin.games.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label class="block mb-2 font-semibold text-gray-700">Name</label>
            <input type="text" name="name" class="w-full p-2 border rounded" required value="{{ old('name') }}">
            @error('name') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-2 font-semibold text-gray-700">Description</label>
            <textarea name="description" class="w-full p-2 border rounded" required rows="4">{{ old('description') }}</textarea>
            @error('description') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-2 font-semibold text-gray-700">Developer</label>
            <input type="text" name="developer" class="w-full p-2 border rounded" required value="{{ old('developer') }}">
            @error('developer') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-2 font-semibold text-gray-700">Price</label>
            <input type="number" step="0.01" name="price" class="w-full p-2 border rounded" required value="{{ old('price') }}">
            @error('price') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-2 font-semibold text-gray-700">Category</label>
            <select name="category_id" class="w-full p-2 border rounded" required>
                <option value="">-- Select Category --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-2 font-semibold text-gray-700">Game ZIP File</label>
            <input type="file" name="file_zip" class="w-full p-2 border rounded" accept=".zip" required>
            @error('file_zip') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-2 font-semibold text-gray-700">Thumbnail</label>
            <input type="file" name="thumbnail" class="w-full p-2 border rounded" accept="image/*" required>
            @error('thumbnail') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 transition text-white px-6 py-2 rounded font-semibold">
            Save
        </button>
    </form>
</div>
@endsection
