# conecta-la

- docker compose up -d

## Rotas de Autenticação

### `POST /register`
- **Descrição**: Registra um novo usuário.
- **Parâmetros**:
  - `name` (string): Nome do usuário.
  - `email` (string): E-mail do usuário.
  - `password` (string): Senha do usuário.
- **Resposta**:
  - **200 OK**: Usuário registrado com sucesso.
  - **422 Unprocessable Content**: Dados inválidos.

### `POST /login`
- **Descrição**: Realiza o login de um usuário autenticado.
- **Parâmetros**:
  - `email` (string): E-mail do usuário.
  - `password` (string): Senha do usuário.
- **Resposta**:
  - **200 OK**: Login bem-sucedido e retorno de token de autenticação.
  - **401 Unauthorized**: Erro de autenticação (credenciais inválidas).

### `POST /logout`
- **Descrição**: Realiza o logout do usuário autenticado.
- **Resposta**:
  - **200 OK**: Usuário deslogado com sucesso.
  - **401 Unauthorized**: Usuário não autenticado.

---

## Rotas de Usuários (Protegidas)

As rotas a seguir estão protegidas por autenticação e requerem um token válido no cabeçalho `Authorization` para acesso.

### `GET /usuarios`
- **Descrição**: Retorna uma lista de todos os usuários.
- **Resposta**:
  - **200 OK**: Lista de usuários.
  - **401 Unauthorized**: Usuário não autenticado.

### `GET /usuarios/{identifier}`
- **Descrição**: Retorna os detalhes de um usuário específico.
- **Parâmetros**:
  - `identifier` (string): ID ou e-mail do usuário.
- **Middleware**: `auth.api`
- **Resposta**:
  - **200 OK**: Detalhes do usuário.
  - **401 Unauthorized**: Usuário não autenticado.
  - **404 Not Found**: Usuário não encontrado.

### `POST /usuarios`
- **Descrição**: Cria um novo usuário.
- **Parâmetros**:
  - `nome` (string): Nome do usuário.
  - `sobrenome` (string): Sobrenome do usuário.
  - `email` (string): E-mail do usuário.
  - `senha` (string): Senha do usuário.
- **Middleware**: `auth.api`
- **Resposta**:
  - **201 Created**: Usuário criado com sucesso.
  - **422 Unprocessable Content**: Dados inválidos.
  - **401 Unauthorized**: Usuário não autenticado.

### `PUT /usuarios/{id}`
- **Descrição**: Atualiza as informações de um usuário existente.
- **Parâmetros**:
  - `id` (int): ID do usuário.
  - `nome` (string): Nome do usuário.
  - `sobrenome` (string): Sobrenome do usuário.
  - `email` (string): E-mail do usuário.
  - `senha` (string): Senha do usuário.
- **Middleware**: `auth.api`
- **Resposta**:
  - **200 OK**: Usuário atualizado com sucesso.
  - **422 Unprocessable Content**: Dados inválidos.
  - **401 Unauthorized**: Usuário não autenticado.
  - **404 Not Found**: Usuário não encontrado.

### `DELETE /usuarios/{id}`
- **Descrição**: Deleta um usuário.
- **Parâmetros**:
  - `id` (int): ID do usuário.
- **Middleware**: `auth.api`
- **Resposta**:
  - **200 OK**: Usuário deletado com sucesso.
  - **401 Unauthorized**: Usuário não autenticado.
  - **404 Not Found**: Usuário não encontrado.
