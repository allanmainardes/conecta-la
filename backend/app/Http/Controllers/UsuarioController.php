<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use App\Services\UsuarioService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

/**
 * Controller responsável por gerenciar usuários.
 */
class UsuarioController extends Controller
{
    protected $usuarioService;

    /**
     * Construtor do controller.
     *
     * @param UsuarioService $usuarioService Serviço responsável por operações relacionadas a usuários.
     */
    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    /**
     * Exibe uma lista de usuários.
     *
     * @param Request $request dados da requisição.
     * 
     * @return JsonResponse retorna um json com as informações de usuários.
     */
    public function index(Request $request): JsonResponse
    {
        $users = $this->usuarioService->getAll();

        if(!empty($users)){
            return response()->json(['usuarios' => $users]);
        }
    }

    /**
     * Armazena um novo usuário.
     *
     * @param UsuarioRequest $request
     * 
     * @return JsonResponse retorna um json com as informações do novo usuário.
     */
    public function store(UsuarioRequest $request): JsonResponse
    {
        try{
            $user = $this->usuarioService->createUsuario($request->only('nome', 'sobrenome', 'email', 'senha'));

            return response()->json(['message' => 'Usuário criado com sucesso', 'usuario' => $user], Response::HTTP_CREATED);
        }catch(Throwable $th){
            return response()->json(['message' => $th->getMessage()], $th->getCode());
        }
    }

    /**
     * Exibe um usuário específico.
     *
     * @param string $identifier id ou email para busca do usuário.
     * 
     * @return JsonResponse retorna um json com as informações do usuário.
     */
    public function show(string $identifier): JsonResponse
    {
        $user = $this->usuarioService->getById($identifier);
        
        return response()->json(['usuario' => $user]);
    }

    /**
     * Atualiza os dados de um usuário.
     *
     * @param UsuarioRequest $request dados do formulário para atualizar um usuário
     * @param int $id id do usuário que será atualizado.
     * 
     * @return JsonResponse retorna um json com as informações do usuário atualizadas.
     */
    public function update(UsuarioRequest $request, int $id): JsonResponse
    {
        $user = $this->usuarioService->updateUsuario($id, $request->only('nome', 'sobrenome', 'email', 'senha'));

        return response()->json(['message' => 'Usuário atualizado com sucesso', 'usuario' => $user]);
    }

    /**
     * Remove um usuário do sistema.
     *
     * @param int $id id do usuário que será removido
     * 
     * @return JsonResponse retorna um json caso a remoção seja feita.
     */
    public function destroy(int $id): JsonResponse
    {
        $user = $this->usuarioService->deleteUsuario($id);

        if($user){
            return response()->json(['message' => 'Usuário removido com sucesso']);
        }
    }
}
