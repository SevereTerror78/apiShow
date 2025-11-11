<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;
use App\Models\Director;
use App\Http\Requests\FilmRequest;
use App\Http\Requests\DirectorsRequest;

use function PHPUnit\Framework\isNull;

/**
 * @apiDefine FilmObject
 * @apiSuccess {Number} id Film azonosítója.
 * @apiSuccess {String} title Film címe.
 * @apiSuccess {String} [release_year] Megjelenés éve (opcionális).
 * @apiSuccess {String} [genre] Műfaj (opcionális).
 * @apiSuccess {String} [description] Leírás (opcionális).
 */
class FilmsController extends Controller
{
        /**
     * @api {get} /films Összes film lekérése
     * @apiName GetFilms
     * @apiGroup Films
     * @apiVersion 1.0.0
     * 
     * @apiDescription Lekéri az adatbázisban található összes filmet.
     * 
     * @apiUse FilmObject
     * 
     * @apiSuccessExample {json} Sikeres válasz:
     *     HTTP/1.1 200 OK
     *     {
     *       "films": [
     *         { "id": 1, "title": "Inception", "release_year": "2010", "genre": "Sci-Fi", "description": "Egy tolvaj, aki az álmokból lop." },
     *         { "id": 2, "title": "Interstellar", "release_year": "2014", "genre": "Sci-Fi" }
     *       ]
     *     }
     */
    public function index()
    {
        $films = Film::all();
        return response()->json([
            'films' => $films,
        ]);
    }
    /**
     * @api {post} /films Új film létrehozása
     * @apiName StoreFilm
     * @apiGroup Films
     * @apiVersion 1.0.0
     * 
     * @apiDescription Új film létrehozása az adatbázisban.
     * 
     * @apiBody {String} title Film címe.
     * @apiBody {String} [release_year] Megjelenés éve.
     * @apiBody {String} [genre] Műfaj.
     * @apiBody {String} [description] Leírás.
     * 
     * @apiUse FilmObject
     * 
     * @apiSuccessExample {json} Sikeres válasz:
     *     HTTP/1.1 201 Created
     *     {
     *       "film": {
     *         "id": 5,
     *         "title": "The Dark Knight",
     *         "release_year": "2008",
     *         "genre": "Action"
     *       }
     *     }
     * 
     * @apiError (422) ValidationError A megadott adatok érvénytelenek.
     */
    public function store(FilmRequest $request)
    {
        $film = Film::create($request->all());

        return response()->json([
            'film' => $film,
        ]);
    }
    /**
     * @api {put} /films/:id Film adatainak frissítése
     * @apiName UpdateFilm
     * @apiGroup Films
     * @apiVersion 1.0.0
     * 
     * @apiDescription Frissíti a megadott azonosítójú film adatait.
     * 
     * @apiParam {Number} id Film azonosítója az URL-ben.
     * @apiBody {String} [title] Film címe.
     * @apiBody {String} [release_year] Megjelenés éve.
     * @apiBody {String} [genre] Műfaj.
     * @apiBody {String} [description] Leírás.
     * 
     * @apiUse FilmObject
     * 
     * @apiSuccessExample {json} Sikeres válasz:
     *     HTTP/1.1 200 OK
     *     {
     *       "film": {
     *         "id": 3,
     *         "title": "Inception (Extended)",
     *         "release_year": "2010",
     *         "genre": "Sci-Fi"
     *       }
     *     }
     * 
     * @apiError (404) NotFound A megadott ID-val nem található film.
     * @apiError (422) ValidationError A megadott adatok érvénytelenek.
     */
    public function update(FilmRequest $request, $id)
    {
        $film = Film::findOrFail($id);
        $film->update($request->all());

        return response()->json([
            'film' => $film,
        ]);
    }
    /**
     * @api {delete} /films/:id Film törlése
     * @apiName DeleteFilm
     * @apiGroup Films
     * @apiVersion 1.0.0
     * 
     * @apiDescription Törli a megadott azonosítójú filmet az adatbázisból.
     * 
     * @apiParam {Number} id Film azonosítója az URL-ben.
     * 
     * @apiSuccess {String} message Üzenet a sikeres törlésről.
     * @apiSuccess {Number} id A törölt film azonosítója.
     * 
     * @apiSuccessExample {json} Sikeres válasz:
     *     HTTP/1.1 200 OK
     *     {
     *       "message": "Film deleted successfully",
     *       "id": 3
     *     }
     * 
     * @apiError (404) NotFound A megadott ID-val nem található film.
     */
    public function destroy($id)
    {
        $film = Film::findOrFail($id);
        $film->delete();
        return response()->json([
            'message' => 'Film deleted successfully',
            'id' => $id
        ]);
    }

//films/directros =>


    public function getFilmDirector($filmId)
    {
        $film = Film::with('director')->findOrFail($filmId);
        return response()->json(['director' => $film->director]);
    }
    

    public function addDirector(Request $request, $filmId)
    {
        $film = Film::findOrFail($filmId);
        $film->director_id = $request->director_id;
        $film->save();
    
        return response()->json([
            'message' => 'Director assigned to film successfully',
            'film_id' => $film->id,
            'director_id' => $film->director_id
        ], 201);
    }
    
    public function updateDirector($filmId, $directorId)
    {
        $film = Film::findOrFail($filmId);
        $director = Director::findOrFail($directorId);
    
        $film->director_id = $director->id;
        $film->save();
    
        return response()->json([
            'message' => 'Director updated for the film successfully',
            'film_id' => $film->id,
            'director_id' => $film->director_id,
        ]);
    }

    public function removeDirector($filmId)
    {
        $film = Film::findOrFail($filmId);
    
        $film->director_id = null;
        $film->save();
    
        return response()->json([
            'message' => 'Director removed (set to Unknown)',
            'film' => $film
        ]);
    }
    
}
