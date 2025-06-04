<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Category;

class MovieController extends Controller
{
    // public function index()
    // {
    //     $movies = Movie::select('id','title', 'synopsis', 'cover_image','year','slug','actors')->paginate(6);
    //     return view('movie.index', compact('movies'));
        
    // }

   public function index()
{
    $movies = Movie::latest()->paginate(6); // atau ->orderBy('created_at', 'desc')

    return view('movie.index', compact('movies'));
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
    return view('movie.create', compact('categories'));
    }

    public function store(Request $request)
    {
        

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'required|string|unique:movies,slug',
            'synopsis'    => 'required|string',
            'year'        => 'required|integer|min:1900|max:2100',
            'actors'      => 'required|string',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        // simpan file gambar
        $imageName = time() . '.' . $request->cover_image->extension();
        $request->cover_image->move(public_path('images'), $imageName);

        // simpan data ke database
        Movie::create([
            'title'       => $validated['title'],
            'slug'        => $validated['slug'],
            'synopsis'    => $validated['synopsis'],
            'year'        => $validated['year'],
            'actors'      => $validated['actors'],
            'cover_image' => $imageName,
            'category_id' => $validated['category_id'],
        ]);

        return redirect()->route('movies.index')->with('success', 'Movie berhasil ditambahkan!');   
    }

    public function update(Request $request, $id)
{
    $movie = Movie::findOrFail($id);

    $validated = $request->validate([
        'title'       => 'required|string|max:255',
        'slug'        => 'required|string|unique:movies,slug,' . $movie->id,
        'synopsis'    => 'required|string',
        'year'        => 'required|integer|min:1900|max:2100',
        'actors'      => 'required|string',
        'category_id' => 'required|exists:categories,id',
        'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // kalau upload cover baru
    if ($request->hasFile('cover_image')) {
        $imageName = time() . '.' . $request->cover_image->extension();
        $request->cover_image->move(public_path('images'), $imageName);
        $movie->cover_image = $imageName;
    }

    $movie->update([
        'title'       => $validated['title'],
        'slug'        => $validated['slug'],
        'synopsis'    => $validated['synopsis'],
        'year'        => $validated['year'],
        'actors'      => $validated['actors'],
        'category_id' => $validated['category_id'],
        'cover_image' => $movie->cover_image
    ]);

    return redirect()->route('movies.index')->with('success', 'Movie berhasil diupdate!');
}



    /**
     * Display the specified resource.
     */
    public function show($id) {
        $movie = Movie::findOrFail($id);
        return view('movie.show', compact('movie'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categories $categories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
{
    if (auth()->user()->role !== 'admin') {
        return redirect()->route('movies.index')->with('error', 'Anda tidak memiliki izin untuk menghapus movie!');
    }
    if ($movie->cover_image && file_exists(public_path('images/' . $movie->cover_image))) {
        unlink(public_path('images/' . $movie->cover_image));
    }

    $movie->delete();

    return redirect()->route('movies.index')->with('success', 'Movie berhasil dihapus!');
}

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Query pencarian berdasarkan title
        $movies = Movie::where('title', 'LIKE', "%{$query}%")->paginate(6);

        return view('movie.index', compact('movies'));
    }

    public function detail_movie($id,$slug) {
        $movie = Movie::find($id);
        // dd($movie);
         return view('movie.detail', compact('movie'));
    }

    public function editPage()
    {
        $movie = Movie::with('category')->get();
        return view('movie.edit', compact('movie'));
    }

    public function editMovie($id)
{
    $movie = Movie::findOrFail($id);
    $categories = Category::all();
    return view('movie.editmovie', compact('movie', 'categories'));
}

}