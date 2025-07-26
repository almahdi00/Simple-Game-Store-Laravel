<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ExtractZip;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $query = Game::with('category');

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhereHas('category', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                });
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        $games = $query->latest()->paginate(12);
        $categories = Category::all();

        return view('games.index', compact('games', 'categories'));
    }


    public function show(Game $game)
    {
        return view('games.show', compact('game'));
    }

    public function play(Game $game)
    {
        $transaction = \App\Models\Transaction::where('user_id', Auth::id())
            ->where('game_id', $game->id)
            ->where('status', 'approved')
            ->first();
        if (!$transaction) {
            abort(403, 'Unauthorized: Purchase not approved.');
        }
        return view('games.play', compact('game'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('games.create', compact('categories'));
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

        $validated['user_id'] = Auth::id();

        // Simpan file ZIP & thumbnail
        $filePath = $request->file('file_zip')->store('games', 'public');
        $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        $extractPath = 'games/' . pathinfo($filePath, PATHINFO_FILENAME);

        // Ekstrak ZIP pakai service
        if (ExtractZip::extract($filePath, $extractPath)) {
            $indexPath = $this->findIndexHtml(Storage::disk('public')->path($extractPath));
            if (!$indexPath) {
                // Hapus file jika tidak ada index.html
                Storage::disk('public')->deleteDirectory($extractPath);
                Storage::disk('public')->delete($filePath);
                return back()->withErrors(['file_zip' => 'Tidak ditemukan file index.html di dalam ZIP.']);
            }
        } else {
            Storage::disk('public')->delete($filePath);
            return back()->withErrors(['file_zip' => 'Gagal mengekstrak file ZIP.']);
        }

        // Simpan game
        $game = Game::create(array_merge($validated, [
            'file_zip' => $filePath,
            'index_path' => $indexPath,
            'thumbnail' => $thumbnailPath,
        ]));

        return redirect()->route('games.my')->with('success', 'Game berhasil diunggah!');
    }

    private function findIndexHtml($directory)
    {
        $files = File::allFiles($directory);
        foreach ($files as $file) {
            if (basename($file) === 'index.html') {
                return str_replace(Storage::disk('public')->path(''), '', $file->getPathname());
            }
        }
        return null;
    }



    public function edit(Game $game)
    {
        if ($game->user_id != Auth::id()) {
            abort(403);
        }

        $categories = Category::all();
        return view('games.edit', compact('game', 'categories'));
    }

    public function update(Request $request, Game $game)
    {
        // Cegah pengguna lain mengedit game yang bukan miliknya
        if ($game->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'developer' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'index_path' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'file_zip' => 'nullable|file|mimes:zip|max:51200', // max 50MB
        ]);

        // Update thumbnail jika ada
        if ($request->hasFile('thumbnail')) {
            if ($game->thumbnail) {
                Storage::disk('public')->delete($game->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        // Update file_zip jika ada
        if ($request->hasFile('file_zip')) {
            if ($game->file_zip) {
                Storage::disk('public')->delete($game->file_zip);
            }
            $validated['file_zip'] = $request->file('file_zip')->store('zips', 'public');
        }

        // Simpan perubahan
        $game->update($validated);

        return redirect()->route('games.my')->with('success', 'Game berhasil diperbarui!');
    }


    public function destroy(Game $game)
    {
        // Cek apakah user adalah pemilik game
        if ($game->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Hapus file thumbnail jika ada
        if ($game->thumbnail) {
            Storage::disk('public')->delete($game->thumbnail);
        }

        // Hapus file ZIP jika ada
        if ($game->file_zip) {
            Storage::disk('public')->delete($game->file_zip);
        }

        // Hapus data game dari database
        $game->delete();

        return back()->with('success', 'Game berhasil dihapus.');
    }



    public function myGames()
    {
        $games = Game::with('category')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('games.my', compact('games'));
    }
}
