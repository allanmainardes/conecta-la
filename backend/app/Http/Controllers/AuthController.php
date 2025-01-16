<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Controlador responsável pela autenticação de usuários, incluindo registro, login e logout.
 */
class AuthController extends Controller
{
    protected $userService;

    /**
     * AuthController constructor.
     *
     * @param UserService $userService Service responsável por operações relacionadas a autenticação na api.
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;    
    }

    /**
     * Registra um novo usuário.
     *
     * @param RegisterRequest $request
     * 
     * @return JsonResponse retorna um json com a informação se o usuário foi criado ou não
     *
     * @throws Exception
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $user = $this->userService->createUser($request->only('name', 'email', 'password'));
                
            return response()->json(['message' => 'Usuário criado com sucesso!', 'user' => $user], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Falha ao registrar'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Realiza o login do usuário.
     *
     * @param Request $request dados da requisição com credenciais.
     * 
     * @return JsonResponse retorna um json com o token ou mensagem de erro
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if(!$token = auth()->attempt($credentials)){
            return response()->json(['error' => 'Credenciais inválidas'], Response::HTTP_UNAUTHORIZED);
        }

        return $this->handleResponse($token);
    }

    /**
     * Realiza o logout do usuário.
     *
     * @param Request $request
     * 
     * @return JsonResponse retorna um json com a mensagem de erro ou sucesso ao fazer logout.
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            auth()->logout();

            return response()->json(['message' => 'Deslogado com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Falha ao deslogar, tente novamente.'], 500);
        }
    }

    /**
     * Retorna a resposta com o token de autenticação.
     *
     * @param string $token
     * 
     * @return JsonResponse json contendo as informações do token
     */
    protected function handleResponse(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }
}
