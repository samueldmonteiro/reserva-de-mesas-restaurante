# Documentação da API

Esta é a documentação dos endpoints da API. Substitua as rotas e descrições conforme necessário para atender ao seu projeto.

## Endpoints

### Autenticação

| Método | Rota               | Descrição                     | Parâmetros (Body)                 | Respostas                                           |
|--------|--------------------|-------------------------------|------------------------------------|----------------------------------------------------|
| POST   | `/api/login`       | Realiza login na aplicação.  | `email`, `password`               | 200: Token JWT<br>401: Credenciais inválidas       |
| POST   | `/api/register`    | Registra um novo usuário.     | `name`, `email`, `password`       | 201: Usuário criado<br>400: Erro de validação      |
| POST   | `/api/logout`      | Faz logout do usuário atual.  | -                                  | 200: Logout bem-sucedido                           |

---

### Usuários

| Método | Rota               | Descrição                     | Parâmetros (Body/Query)           | Respostas                                           |
|--------|--------------------|-------------------------------|------------------------------------|----------------------------------------------------|
| GET    | `/api/users`       | Lista todos os usuários.      | `?page`, `?per_page`              | 200: Lista de usuários                             |
| GET    | `/api/users/{id}`  | Obtém os detalhes de um usuário específico. | -                    | 200: Dados do usuário<br>404: Usuário não encontrado |
| PUT    | `/api/users/{id}`  | Atualiza informações de um usuário. | `name`, `email`               | 200: Usuário atualizado<br>400: Erro de validação  |
| DELETE | `/api/users/{id}`  | Deleta um usuário específico. | -                                  | 204: Exclusão bem-sucedida                         |

---

### Produtos

| Método | Rota               | Descrição                     | Parâmetros (Body/Query)           | Respostas                                           |
|--------|--------------------|-------------------------------|------------------------------------|----------------------------------------------------|
| GET    | `/api/products`    | Lista todos os produtos.      | `?page`, `?per_page`, `?search`   | 200: Lista de produtos                             |
| GET    | `/api/products/{id}`| Obtém detalhes de um produto específico. | -                   | 200: Dados do produto
