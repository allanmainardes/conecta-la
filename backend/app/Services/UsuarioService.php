<?php

namespace App\Services;

use App\Exceptions\UsuarioCreationException;
use App\Exceptions\UsuarioNotFoundException;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

/**
 * Serviço responsável por operações relacionadas aos usuários.
 */
class UsuarioService
{
    /**
     * Retorna todos os usuários cadastrados.
     *
     * @return Collection
     *
     * @throws UsuarioNotFoundException Se nenhum usuário for encontrado.
     */
    public function getAll(): Collection
    {
        $users = Usuario::all();

        if(empty($users)){
            throw new UsuarioNotFoundException('Nenhum usuário encontrado.');
        }

        return $users;
    }

    /**
     * Cria um novo usuário.
     *
     * @param array $data Dados para criação do usuário.
     * 
     * @return Usuario O usuário criado.
     *
     * @throws UsuarioCreationException Se o usuário não puder ser criado.
     */
    public function createUsuario(array $data): Usuario
    {
        $user = Usuario::create([
            'nome' => $data['nome'],
            'sobrenome' => $data['sobrenome'],
            'email' => $data['email'],
            'senha' => Hash::make($data['senha']),
        ]);

        if(empty($user)){
            throw new UsuarioCreationException();
        }

        return $user;
    }

    /**
     * Retorna um usuário pelo identificador.
     *
     * @param string $identifier ID ou email do usuário.
     * 
     * @return Usuario O usuário encontrado ou null.
     *
     * @throws UsuarioNotFoundException Se o usuário não for encontrado.
     */
    public function getById(string $identifier): Usuario
    {
        $user = is_numeric($identifier) ? Usuario::find($identifier) : Usuario::where('email', $identifier)->first();
        if(empty($user)){
            throw new UsuarioNotFoundException();
        }

        return $user;

    }

    /**
     * Atualiza os dados de um usuário.
     *
     * @param int $id ID do usuário.
     * @param array $data Dados para atualização.
     * 
     * @return Usuario O usuário atualizado ou null.
     *
     * @throws UsuarioNotFoundException Se o usuário não for encontrado.
     */
    public function updateUsuario(int $id, array $data): Usuario
    {
        $user = Usuario::find($id);
        
        if(empty($user)){
            throw new UsuarioNotFoundException();
        }

        $user->fill([
            'nome' => $data['nome'],
            'sobrenome' => $data['sobrenome'],
            'email' => $data['email'],
            'senha' => Hash::make($data['senha']),
        ]);

        $user->save();

        return $user;
    }

    /**
     * Remove um usuário pelo ID.
     *
     * @param int $id ID do usuário.
     * 
     * @return bool True se o usuário foi excluído, false caso contrário.
     *
     * @throws UsuarioNotFoundException Se o usuário não for encontrado.
     */
    public function deleteUsuario(int $id): bool
    {
        $user = Usuario::find($id);
        
        if(empty($user)){
            throw new UsuarioNotFoundException();
        }

        return $user->delete();
    }
}
