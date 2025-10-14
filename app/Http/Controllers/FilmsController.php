<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;
use App\Http\Requests\FilmRequest;

class FilmsController extends Controller
{
    public function index()
    {
        $films = Film::all();
        return response()->json([
            'films' => $films,
        ]);
    }

    public function store(FilmRequest $request)
    {
        $film = Film::create($request->all());

        return response()->json([
            'film' => $film,
        ]);
    }

    public function update(FilmRequest $request, $id)
    {
        $film = Film::findOrFail($id);
        $film->update($request->all());

        return response()->json([
            'film' => $film,
        ]);
    }

    public function destroy($id)
    {
        $film = Film::findOrFail($id);
        $film->delete();
        return response()->json([
            'message' => 'Film deleted successfully',
            'id' => $id
        ]);
    }
}
