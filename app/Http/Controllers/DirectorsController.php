<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Director;
use App\Http\Requests\DirectorsRequest;
/**
 * @apiDefine DirectorObject
 * @apiSuccess {Number} id Rendező azonosítója.
 * @apiSuccess {String} name Rendező neve.
 * @apiSuccess {String} [birth_date] Születési dátum (opcionális).
 * @apiSuccess {String} [bio] Rövid leírás (opcionális).
 */
class DirectorsController extends Controller
{
        /**
     * @api {get} /directors Összes rendező lekérése
     * @apiName GetDirectors
     * @apiGroup Directors
     * @apiVersion 1.0.0
     * 
     * @apiDescription Lekéri az adatbázisban található összes rendezőt.
     * 
     * @apiUse DirectorObject
     * 
     * @apiSuccessExample {json} Sikeres válasz:
     *     HTTP/1.1 200 OK
     *     {
     *       "director": [
     *         { "id": 1, "name": "Steven Spielberg", "birth_date": "1946-12-18", "bio": "Oscar-díjas amerikai filmrendező." },
     *         { "id": 2, "name": "Christopher Nolan", "birth_date": "1970-07-30" }
     *       ]
     *     }
     */
    public function index()
    {
        $director = Director::all();
        return response()->json([
            'director' => $director,
        ]);
    }
    /**
     * @api {post} /directors Új rendező létrehozása
     * @apiName StoreDirector
     * @apiGroup Directors
     * @apiVersion 1.0.0
     * 
     * @apiDescription Új rendező létrehozása az adatbázisban.
     * 
     * @apiBody {String} name Rendező neve.
     * @apiBody {String} [birth_date] Születési dátum.
     * @apiBody {String} [bio] Rövid leírás.
     * 
     * @apiUse DirectorObject
     * 
     * @apiSuccessExample {json} Sikeres válasz:
     *     HTTP/1.1 201 Created
     *     {
     *       "director": {
     *         "id": 5,
     *         "name": "Martin Scorsese",
     *         "birth_date": "1942-11-17"
     *       }
     *     }
     * 
     * @apiError (422) ValidationError A megadott adatok érvénytelenek.
     */
    public function store(DirectorsRequest $request)
    {
        $director = Director::create($request->all());

        return response()->json([
            'director' => $director,
        ]);
    }
    /**
     * @api {put} /directors/:id Rendező adatainak frissítése
     * @apiName UpdateDirector
     * @apiGroup Directors
     * @apiVersion 1.0.0
     * 
     * @apiDescription Frissíti a megadott azonosítójú rendező adatait.
     * 
     * @apiParam {Number} id Rendező azonosítója az URL-ben.
     * @apiBody {String} [name] Rendező neve.
     * @apiBody {String} [birth_date] Születési dátum.
     * @apiBody {String} [bio] Rövid leírás.
     * 
     * @apiUse DirectorObject
     * 
     * @apiSuccessExample {json} Sikeres válasz:
     *     HTTP/1.1 200 OK
     *     {
     *       "director": {
     *         "id": 3,
     *         "name": "Quentin Tarantino",
     *         "birth_date": "1963-03-27"
     *       }
     *     }
     * 
     * @apiError (404) NotFound A megadott ID-val nem található rendező.
     * @apiError (422) ValidationError A megadott adatok érvénytelenek.
     */
    public function update(DirectorsRequest $request, $id)
    {
        $director = Director::findOrFail($id);
        $director->update($request->all());

        return response()->json([
            'director' => $director,
        ]);
    }
 /**
     * @api {delete} /directors/:id Rendező törlése
     * @apiName DeleteDirector
     * @apiGroup Directors
     * @apiVersion 1.0.0
     * 
     * @apiDescription Törli a megadott azonosítójú rendezőt az adatbázisból.
     * 
     * @apiParam {Number} id Rendező azonosítója az URL-ben.
     * 
     * @apiSuccess {String} message Üzenet a sikeres törlésről.
     * @apiSuccess {Number} id A törölt rendező azonosítója.
     * 
     * @apiSuccessExample {json} Sikeres válasz:
     *     HTTP/1.1 200 OK
     *     {
     *       "message": "Director deleted successfully",
     *       "id": 3
     *     }
     * 
     * @apiError (404) NotFound A megadott ID-val nem található rendező.
     */
    public function destroy($id)
    {
        $director = Director::findOrFail($id);
        $director->delete();
        return response()->json([
            'message' => 'Director deleted successfully',
            'id' => $id
        ]);
    }
    /**
    * @OA\Get(
    *     path="/api/directors/{id}/films",
    *     summary="Lekéri a rendező összes filmjét",
    *     tags={"Directors"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="A rendező azonosítója",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Sikeres lekérés",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(
    *                 property="films",
    *                 type="array",
    *                 @OA\Items(ref="#/components/schemas/Film")
    *             )
    *         )
    *     )
    * )
    */
    public function getDirectorFilms($id)
    {
        $director = Director::with('films')->findOrFail($id);
    
        return response()->json([
            'films' => $director->films,
        ]);
    }
    
}
