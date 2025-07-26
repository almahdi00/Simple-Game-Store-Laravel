<?php
namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Game::query();
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }
        $games = $query->paginate(9);
        $categories = Category::all();
        return view('home', compact('games', 'categories'));
    }
}