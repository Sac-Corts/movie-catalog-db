<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    // Obtener todos los registros
    public function index()
    {
        return Movie::all();
    }

    // Obtener un registro específico por ID
    public function show($id)
    {
        return Movie::findOrFail($id);
    }

    // Crear un nuevo registro
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'synopsis' => 'required|string',
            'year' => 'required|integer',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $movie = new Movie();
        $movie->title = $request->input('title');
        $movie->synopsis = $request->input('synopsis');
        $movie->year = $request->input('year');

        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $coverPath = 'covers/' . uniqid() . '.' . $cover->getClientOriginalExtension();
            $cover->storeAs('public', $coverPath);
            $movie->cover = $coverPath;
        }

        $movie->save();

        return response()->json($movie, 201);
    }

    // Actualizar un registro existente
    public function update(Request $request, $id)
    {
        $movie = Movie::findOrFail($id);
    
        $movie->title = $request->input('title');
        $movie->synopsis = $request->input('synopsis');
        $movie->year = $request->input('year');
    
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $coverPath = 'covers/' . uniqid() . '.' . $cover->getClientOriginalExtension();
            $cover->storeAs('public', $coverPath);
            $movie->cover = $coverPath;
        }
    
        $movie->save();
    
        return response()->json($movie);
    }

    // Eliminar un registro
    public function destroy($id)
    {
        Movie::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
