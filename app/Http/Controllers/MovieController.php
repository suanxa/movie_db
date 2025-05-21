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
    public function update(Request $request, Categories $categories)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categories $categories)
    {
        //
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
}