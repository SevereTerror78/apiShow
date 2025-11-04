<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Series;
use App\Http\Requests\SeriesRequest;

/**
 * @apiDefine SeriesObject
 * @apiSuccess {Number} id Sorozat azonosítója.
 * @apiSuccess {String} title Sorozat címe.
 * @apiSuccess {String} [release_year] Megjelenés éve (opcionális).
 * @apiSuccess {String} [genre] Műfaj (opcionális).
 * @apiSuccess {String} [description] Rövid leírás (opcionális).
 * @apiSuccess {Number} [seasons] Évadok száma (opcionális).
 */
class SeriesController extends Controller
{
        /**
     * @api {get} /series Összes sorozat lekérése
     * @apiName GetSeries
     * @apiGroup Series
     * @apiVersion 1.0.0
     * 
     * @apiDescription Lekéri az adatbázisban található összes sorozatot.
     * 
     * @apiUse SeriesObject
     * 
     * @apiSuccessExample {json} Sikeres válasz:
     *     HTTP/1.1 200 OK
     *     {
     *       "series": [
     *         { "id": 1, "title": "Breaking Bad", "release_year": "2008", "genre": "Crime", "seasons": 5 },
     *         { "id": 2, "title": "Game of Thrones", "release_year": "2011", "genre": "Fantasy", "seasons": 8 }
     *       ]
     *     }
     */
    public function index()
    {
        $series = Series::all();
        return response()->json([
            'series' => $series,
        ]);
    }

    /**
     * @api {post} /series Új sorozat létrehozása
     * @apiName StoreSeries
     * @apiGroup Series
     * @apiVersion 1.0.0
     * 
     * @apiDescription Új sorozat létrehozása az adatbázisban.
     * 
     * @apiBody {String} title Sorozat címe.
     * @apiBody {String} [release_year] Megjelenés éve.
     * @apiBody {String} [genre] Műfaj.
     * @apiBody {String} [description] Rövid leírás.
     * @apiBody {Number} [seasons] Évadok száma.
     * 
     * @apiUse SeriesObject
     * 
     * @apiSuccessExample {json} Sikeres válasz:
     *     HTTP/1.1 201 Created
     *     {
     *       "serie": {
     *         "id": 3,
     *         "title": "The Witcher",
     *         "release_year": "2019",
     *         "genre": "Fantasy",
     *         "seasons": 3
     *       }
     *     }
     * 
     * @apiError (422) ValidationError A megadott adatok érvénytelenek.
     */
    public function store(SeriesRequest $request)
    {
        $serie = Series::create($request->all());

        return response()->json([
            'serie' => $serie,
        ]);
    }
    /**
     * @api {put} /series/:id Sorozat adatainak frissítése
     * @apiName UpdateSeries
     * @apiGroup Series
     * @apiVersion 1.0.0
     * 
     * @apiDescription Frissíti a megadott azonosítójú sorozat adatait.
     * 
     * @apiParam {Number} id Sorozat azonosítója az URL-ben.
     * @apiBody {String} [title] Sorozat címe.
     * @apiBody {String} [release_year] Megjelenés éve.
     * @apiBody {String} [genre] Műfaj.
     * @apiBody {String} [description] Rövid leírás.
     * @apiBody {Number} [seasons] Évadok száma.
     * 
     * @apiUse SeriesObject
     * 
     * @apiSuccessExample {json} Sikeres válasz:
     *     HTTP/1.1 200 OK
     *     {
     *       "serie": {
     *         "id": 2,
     *         "title": "Game of Thrones (Extended)",
     *         "release_year": "2011",
     *         "genre": "Fantasy",
     *         "seasons": 8
     *       }
     *     }
     * 
     * @apiError (404) NotFound A megadott ID-val nem található sorozat.
     * @apiError (422) ValidationError A megadott adatok érvénytelenek.
     */
    public function update(SeriesRequest $request, $id)
    {
        $serie = Series::findOrFail($id);
        $serie->update($request->all());

        return response()->json([
            'serie' => $serie,
        ]);
    }
    /**
     * @api {delete} /series/:id Sorozat törlése
     * @apiName DeleteSeries
     * @apiGroup Series
     * @apiVersion 1.0.0
     * 
     * @apiDescription Törli a megadott azonosítójú sorozatot az adatbázisból.
     * 
     * @apiParam {Number} id Sorozat azonosítója az URL-ben.
     * 
     * @apiSuccess {String} message Üzenet a sikeres törlésről.
     * @apiSuccess {Number} id A törölt sorozat azonosítója.
     * 
     * @apiSuccessExample {json} Sikeres válasz:
     *     HTTP/1.1 200 OK
     *     {
     *       "message": "Serie deleted successfully",
     *       "id": 3
     *     }
     * 
     * @apiError (404) NotFound A megadott ID-val nem található sorozat.
     */
    public function destroy($id)
    {
        $serie = Series::findOrFail($id);
        $serie->delete();
        return response()->json([
            'message' => 'Serie deleted successfully',
            'id' => $id
        ]);
    }
}