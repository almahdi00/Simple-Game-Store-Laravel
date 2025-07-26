@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Edit Category</h1>
    <form action="{{ route('admin.categories.update', $category) }}" method="POST" novalidate>
        @csrf
        @method('PUT')
        <div class="mb-6">
            <label for="name" class="block mb-2 font-semibold text-gray-700">Name</label>
            <input
                type="text"
                name="name"
                id="name"
                value="{{ old('name', $category->name) }}"
                class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
                autofocus
            >
            @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 transition text-white px-6 py-3 rounded font-semibold">
            Update
        </button>
    </form>
</div>
@endsection
