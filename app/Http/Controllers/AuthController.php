<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="AuthController",
 *     description="Opérations sur l'authentification"
 * )
 */
class AuthController extends Controller
{
public function __construct()
{
$this->middleware('auth:api', ['except' => ['login', 'register']]);
}/**
* Authentification et génération du token JWT
*/
/**
     * @OA\Post(
     * path="/api/auth/login",
     * summary="Login",
     * tags={"Authentification"},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"email","password"},
     * @OA\Property(property="email", type="string", format="email", 
     * example="john@example.com"), 
     * @OA\Property(property="password", type="string", format="password", 
     * example="secret")
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Utilisateur authentifié avec succès",
     * @OA\JsonContent(
     * @OA\Property(property="user", type="object"),
     * @OA\Property(property="token", type="string", example="1|abcdef123456")
     * )
     * ),
     * @OA\Response(
     * response=422,
     * description="Erreur de validation"
     * )
     *)
     */
public function login(Request $request)
{
$validator = Validator::make($request->all(), [
'email' => 'required|email',
'password' => 'required|string|min:6',
]);
if ($validator->fails()) {
return response()->json($validator->errors(), 422);
}
if (!$token = JWTAuth::attempt($validator->validated())) {
return response()->json(['error' => 'Unauthorized'], 401);
}
return $this->createNewToken($token);
}
/**
* Enregistrement d'un nouvel utilisateur
*/
/**
     * @OA\Post(
     * path="/api/auth/register",
     * summary="Enregistrement d'un nouvel utilisateur",
     * tags={"Authentification"},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"name","email","password"},
     * @OA\Property(property="name", type="string", example="John Doe"),
     * @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     * @OA\Property(property="password", type="string", format="password", example="secret"),
     * @OA\Property(property="password_confirmation", type="string", format="password", example="secret")
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Utilisateur enregistré avec succès",
     * @OA\JsonContent(
     * @OA\Property(property="user", type="object"),
     * @OA\Property(property="token", type="string", example="1|abcdef123456")
     * )
     * ),
     * @OA\Response(
     * response=422,
     * description="Erreur de validation"
     * )
     *)
     */
public function register(Request $request)
{
$validator = Validator::make($request->all(), [
'name' => 'required|string|between:2,100',
'email' => 'required|string|email|max:100|unique:users',
'password' => 'required|string|min:6',
]);
if ($validator->fails()) {
return response()->json($validator->errors(), 400);
}
$user = User::create(array_merge(
$validator->validated(),
['password' => bcrypt($request->password),
/* 'is_admin' => false // Important ici */
]

));
return response()->json([
'message' => 'User successfully registered',
'user' => $user
], 201);}
/**
* Déconnexion - Invalide le token
*/
public function logout()
{
JwtAuth::logout();
return response()->json(['message' => 'User successfully signed out']);
}
/**
* Rafraîchir le token JWT
*/
/**
      * @OA\Post(
      *     path="/api/auth/refresh",
      *     summary="Actualisation du token",
      *     tags={"Authentification"},
      *     security={{"bearerAuth":{}}},
      *     @OA\Response(
      *         response=200,
      *         description="Token rafraîchi avec succès",
      *     ),
      *     @OA\Response(
      *         response=401,
      *         description="Non autorisé"
      *     )
      * )
      */
public function refresh()
{
return $this->createNewToken(JwtAuth::refresh());
}
/**
* Récupérer le profil utilisateur authentifié
*/
/**
      * @OA\Get(
      *     path="/api/auth/user-profile",
      *     summary="Information de l'utilisateur",
      *     tags={"Authentification"},
      *     security={{"bearerAuth":{}}},
      *     @OA\Response(
      *         response=200,
      *         description="Récupération du profil utilisateur",
      *     ),
      *     @OA\Response(
      *         response=401,
      *         description="Non autorisé"
      *     )
      * )
      */
public function userProfile()
{
return response()->json(JwtAuth::user());
}
/**
* Structure de la réponse avec token JWT
*/
/**
      * @OA\Post(
      *     path="/api/auth/token",
      *     summary="Génération du token",
      *     tags={"Authentification"},
      *     security={{"bearerAuth":{}}},
      *     @OA\Response(
      *         response=200,
      *         description="creation du token",
      *     ),
      *     @OA\Response(
      *         response=401,
      *         description="Non autorisé"
      *     )
      * )
      */
protected function createNewToken($token)
{
return response()->json([
'access_token' => $token,
'token_type' => 'bearer',
'expires_in' => JwtAuth::factory()->getTTL() * 60,
'user' => JwtAuth::user()
]);
}
}