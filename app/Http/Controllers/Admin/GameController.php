<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Category;
use App\Services\ExtractZip;  // <-- PASTIKAN INI ADA
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $query = Game::query();
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhereHas('category', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                });
        }
        $games = $query->paginate(10);
        return view('admin.games.index', compact('games'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.games.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'developer' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'file_zip' => 'required|file|mimes:zip|max:204800',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        $filePath = $request->file('file_zip')->store('games', 'public');
        $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        $extractPath = 'games/' . pathinfo($filePath, PATHINFO_FILENAME);

        // Extract ZIP
        if (ExtractZip::extract($filePath, $extractPath)) {
            // Find index.html
            $indexPath = $this->findIndexHtml(Storage::disk('public')->path($extractPath));
            if (!$indexPath) {
                Storage::disk('public')->deleteDirectory($extractPath);
                Storage::disk('public')->delete($filePath);
                return back()->withErrors(['file_zip' => 'No index.html found in ZIP file.']);
            }
        } else {
            Storage::disk('public')->delete($filePath);
            return back()->withErrors(['file_zip' => 'Failed to extract ZIP file.']);
        }

        Game::create(array_merge($validated, [
            'file_zip' => $filePath,
            'index_path' => $indexPath,
            'thumbnail' => $thumbnailPath,
        ]));

        return redirect()->route('admin.games.index')->with('success', 'Game created successfully.');
    }

    private function findIndexHtml($directory)
    {
        $files = \Illuminate\Support\Facades\File::allFiles($directory);
        foreach ($files as $file) {
            if (basename($file) === 'index.html') {
                return str_replace(Storage::disk('public')->path(''), '', $file->getPathname());
            }
        }
        return null;
    }

    public function edit(Game $game)
    {
        $categories = Category::all();
        return view('admin.games.edit', compact('game', 'categories'));
    }

    public function update(Request $request, Game $game)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'developer' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'file_zip' => 'nullable|file|mimes:zip|max:204800',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('file_zip')) {
            // Hapus file ZIP dan folder ekstrak lama
            Storage::disk('public')->delete($game->file_zip);
            $oldExtractPath = 'games/' . pathinfo($game->file_zip, PATHINFO_FILENAME);
            Storage::disk('public')->deleteDirectory($oldExtractPath);

            // Simpan file ZIP baru
            $newZipPath = $request->file('file_zip')->store('games', 'public');
            $extractPath = 'games/' . pathinfo($newZipPath, PATHINFO_FILENAME);

            // Ekstrak ZIP baru pakai ExtractZip service
            if (!ExtractZip::extract($newZipPath, $extractPath)) {
                return back()->withErrors(['file_zip' => 'Failed to extract ZIP file.']);
            }

            // Cari index.html di folder ekstrak
            $indexPath = $this->findIndexHtml(Storage::disk('public')->path($extractPath));
            if (!$indexPath) {
                // Jika index.html tidak ditemukan, hapus file dan folder ekstrak yang baru
                Storage::disk('public')->delete($newZipPath);
                Storage::disk('public')->deleteDirectory($extractPath);
                return back()->withErrors(['file_zip' => 'No index.html found in ZIP file.']);
            }

            $validated['file_zip'] = $newZipPath;
            $validated['index_path'] = $indexPath;
        }

        if ($request->hasFile('thumbnail')) {
            Storage::disk('public')->delete($game->thumbnail);
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $game->update($validated);

        return redirect()->route('admin.games.index')->with('success', 'Game updated successfully.');
    }



    public function destroy(Game $game)
    {
        Storage::disk('public')->delete([$game->file_zip, $game->thumbnail]);
        $extractPath = 'games/' . pathinfo($game->file_zip, PATHINFO_FILENAME);
        Storage::disk('public')->deleteDirectory($extractPath);
        $game->delete();
        return redirect()->route('admin.games.index')->with('success', 'Game deleted successfully.');
    }
}
