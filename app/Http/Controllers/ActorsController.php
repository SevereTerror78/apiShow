<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actor;
use App\Http\Requests\ActorsRequest;
/**
 * @apiDefine ActorObject
 * @apiSuccess {Number} id Színész azonosítója.
 * @apiSuccess {String} name Színész neve.
 * @apiSuccess {String} [birth_date] Születési dátum (opcionális).
 * @apiSuccess {String} [bio] Rövid leírás (opcionális).
 */
class ActorsController extends Controller
{
        /**
     * @api {get} /actors Összes színész lekérése
     * @apiName GetActors
     * @apiGroup Actors
     * @apiVersion 1.0.0
     * 
     * @apiDescription Lekéri az adatbázisban található összes színészt.
     * 
     * @apiUse ActorObject
     * 
     * @apiSuccessExample {json} Sikeres válasz:
     *     HTTP/1.1 200 OK
     *     {
     *       "acters": [
     *         { "id": 1, "name": "Tom Hanks", "birth_date": "1956-07-09", "bio": "Oscar-díjas amerikai színész." },
     *         { "id": 2, "name": "Natalie Portman", "birth_date": "1981-06-09" }
     *       ]
     *     }
     */
    public function index()
    {
        $actors = Actor::all();
        return response()->json([
            'acters' => $actors,
        ]);
    }
    /**
     * @api {post} /actors Új színész létrehozása
     * @apiName StoreActor
     * @apiGroup Actors
     * @apiVersion 1.0.0
     * 
     * @apiDescription Új színész létrehozása az adatbázisban.
     * 
     * @apiBody {String} name Színész neve.
     * @apiBody {String} [birth_date] Születési dátum.
     * @apiBody {String} [bio] Rövid leírás.
     * 
     * @apiUse ActorObject
     * 
     * @apiSuccessExample {json} Sikeres válasz:
     *     HTTP/1.1 201 Created
     *     {
     *       "actor": {
     *         "id": 5,
     *         "name": "Leonardo DiCaprio",
     *         "birth_date": "1974-11-11"
     *       }
     *     }
     * 
     * @apiError (422) ValidationError A megadott adatok érvénytelenek.
     */
    public function store(ActorsRequest $request)
    {
        $actor = Actor::create($request->all());

        return response()->json([
            'actor' => $actor,
        ]);
    }
    /**
     * @api {put} /actors/:id Színész adatainak frissítése
     * @apiName UpdateActor
     * @apiGroup Actors
     * @apiVersion 1.0.0
     * 
     * @apiDescription Frissíti a megadott azonosítójú színész adatait.
     * 
     * @apiParam {Number} id Színész azonosítója az URL-ben.
     * @apiBody {String} [name] Színész neve.
     * @apiBody {String} [birth_date] Születési dátum.
     * @apiBody {String} [bio] Rövid leírás.
     * 
     * @apiUse ActorObject
     * 
     * @apiSuccessExample {json} Sikeres válasz:
     *     HTTP/1.1 200 OK
     *     {
     *       "actor": {
     *         "id": 5,
     *         "name": "Leonardo Wilhelm DiCaprio",
     *         "birth_date": "1974-11-11"
     *       }
     *     }
     * 
     * @apiError (404) NotFound A megadott ID-val nem található színész.
     * @apiError (422) ValidationError A megadott adatok érvénytelenek.
     */
    public function update(ActorsRequest $request, $id)
    {
        $actor = Actor::findOrFail($id);
        $actor->update($request->all());

        return response()->json([
            'actor' => $actor,
        ]);
    }
    /**
     * @api {delete} /actors/:id Színész törlése
     * @apiName DeleteActor
     * @apiGroup Actors
     * @apiVersion 1.0.0
     * 
     * @apiDescription Törli a megadott azonosítójú színészt az adatbázisból.
     * 
     * @apiParam {Number} id Színész azonosítója az URL-ben.
     * 
     * @apiSuccess {String} message Üzenet a sikeres törlésről.
     * @apiSuccess {Number} id A törölt színész azonosítója.
     * 
     * @apiSuccessExample {json} Sikeres válasz:
     *     HTTP/1.1 200 OK
     *     {
     *       "message": "Actor deleted successfully",
     *       "id": 5
     *     }
     * 
     * @apiError (404) NotFound A megadott ID-val nem található színész.
     */
    public function destroy($id)
    {
        $actor = Actor::findOrFail($id);
        $actor->delete();
        return response()->json([
            'message' => 'Actor deleted successfully',
            'id' => $id
        ]);
    }
    
    /**
     * @OA\Get(
     *     path="/api/actors/{id}/films",
     *     summary="Lekéri a színész összes filmjét",
     *     tags={"Actors"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="A színész azonosítója",
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
     * 
     * @api {get} /actors/:id/films Színész filmjeinek lekérése
     * @apiName GetActorFilms
     * @apiGroup Actors
     * @apiVersion 1.0.0
     * 
     * @apiDescription Lekéri a megadott színészhez tartozó összes filmet.
     * 
     * @apiParam {Number} id Színész azonosítója az URL-ben.
     * 
     * @apiSuccess {Object[]} films A színészhez kapcsolódó filmek listája.
     * 
     * @apiSuccessExample {json} Sikeres válasz:
     *     HTTP/1.1 200 OK
     *     {
     *       "films": [
     *         { "id": 1, "title": "Inception", "year": 2010 },
     *         { "id": 2, "title": "The Revenant", "year": 2015 }
     *       ]
     *     }
     * 
     * @apiError (404) NotFound A megadott ID-val nem található színész.
     */
    public function getActorFilms($id)
    {
        $actor = Actor::with('films')->findOrFail($id);

        return response()->json([
            'films' => $actor->films,
        ]);
    }
}
