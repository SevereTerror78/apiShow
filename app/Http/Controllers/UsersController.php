<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
/**
 * @apiDefine UserObject
 * @apiSuccess {Number} id Felhasználó azonosítója.
 * @apiSuccess {String} name Felhasználó neve.
 * @apiSuccess {String} email Felhasználó e-mail címe.
 * @apiSuccess {String} [token] Hitelesítési token (login esetén).
 */
class UsersController extends Controller
{
        /**
     * @api {post} /login Felhasználó bejelentkezése
     * @apiName LoginUser
     * @apiGroup Users
     * @apiVersion 1.0.0
     * 
     * @apiDescription Bejelentkezteti a felhasználót e-mail és jelszó alapján, majd visszaadja a hozzá tartozó API tokent.
     * 
     * @apiBody {String} email Felhasználó e-mail címe.
     * @apiBody {String} password Felhasználó jelszava.
     * 
     * @apiSuccess {Object} user A bejelentkezett felhasználó adatai.
     * @apiUse UserObject
     * 
     * @apiSuccessExample {json} Sikeres válasz:
     *     HTTP/1.1 200 OK
     *     {
     *       "user": {
     *         "id": 1,
     *         "name": "John Doe",
     *         "email": "john@example.com",
     *         "token": "1|2szsdlkfm9q0wslajfdlsj"
     *       }
     *     }
     * 
     * @apiError (401) Unauthorized Érvénytelen e-mail cím vagy jelszó.
     * @apiError (422) ValidationError A megadott adatok érvénytelenek.
     */
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $request->validate(([
            'email'=>'required|email',
            'password' => 'required',
        ]));

        $user = User::where('email', $email)->first();

        if(!$user || !Hash::check($password, $password ? $user->password:'')){
            return response()->json([
                'message' => 'Invalid e-mail or password',
            ], 401);
        }

        $user->tokens()->delete();
        $user->token = $user->createToken('access')->plainTextToken;

        return response()->json([
            'user' => $user,
        ]);
    }
    
    /**
     * @api {get} /users Felhasználók listázása
     * @apiName GetUsers
     * @apiGroup Users
     * @apiVersion 1.0.0
     * 
     * @apiDescription Lekéri az összes regisztrált felhasználót.  
     * Autentikáció szükséges.
     * 
     * @apiHeader {String} Authorization Bearer token
     * 
     * @apiUse UserObject
     * 
     * @apiSuccessExample {json} Sikeres válasz:
     *     HTTP/1.1 200 OK
     *     {
     *       "users": [
     *         { "id": 1, "name": "John Doe", "email": "john@example.com" },
     *         { "id": 2, "name": "Jane Smith", "email": "jane@example.com" }
     *       ]
     *     }
     * 
     * @apiError (401) Unauthorized A kéréshez érvényes token szükséges.
     */
    public function index(){
        $users = User::all();
        return response()->json([
            'users' => $users,
        ]);
    }
}
