# Documentação da API

## Endpoints

### Autenticação

| Método | Rota               | Descrição                     | Parâmetros (Body)                 | Respostas                                           |
|--------|--------------------|-------------------------------|------------------------------------|----------------------------------------------------|
| POST   | `/api/v1/auth/login/client`       | Autenticação do Cliente  | `email`, `password`               | 200: Token JWT, Objeto cliente<br>401: Credenciais inválidas|

---

### Cliente

| Método | Rota               | Descrição                     | Parâmetros (Body/Query)           | Respostas                                           |
|--------|--------------------|-------------------------------|------------------------------------|----------------------------------------------------|
| POST    | `/api/v1/client/register`       | Registro do cliente.      | `name`, `email`, `telphone`, `password`              | 200: Objeto cliente, Token JWT<br>400: Parâmetros incorretos|

---
