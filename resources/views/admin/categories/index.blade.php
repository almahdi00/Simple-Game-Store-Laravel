@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Manage Categories</h1>
    
    <a href="{{ route('admin.categories.create') }}" 
       class="bg-green-600 hover:bg-green-700 transition text-white px-5 py-2 rounded mb-6 inline-block font-semibold">
        Add Category
    </a>

    <table class="w-full border border-gray-300 rounded overflow-hidden">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-3 border-b border-gray-300">Name</th>
                <th class="p-3 border-b border-gray-300">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr class="hover:bg-gray-50">
                    <td class="p-3 border-b border-gray-300">{{ $category->name }}</td>
                    <td class="p-3 border-b border-gray-300 space-x-3">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $categories->links() }}
    </div>
</div>
@endsection
