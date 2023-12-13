# Napped API

## Introdução

Bem-vindo ao projeto Napped API! O Napped é uma fonte de informações sobre o mundo nerd, abrangendo séries, filmes, animes e jogos. Este README fornecerá orientações sobre como configurar, usar e contribuir para este projeto.

## Funcionalidades

- **Registro de Usuário e Login:** Os usuários podem se registrar para obter uma conta, fazer login para acessar recursos exclusivos, atualizar informações e deletar sua conta.

## Configuração do Ambiente

### 1. Pré-requisitos

- PHP 8 ou superior
- Composer instalado em seu sistema
- MySQL ou outro banco de dados suportado

### 2. Configuração do Banco de Dados

- Crie um banco de dados MySQL chamado `napped`.

### 3. Configuração do .env

- Copie o arquivo `.env.example` para `.env`:

```bash
cp .env.example .env
```

- Configure as variáveis de ambiente no arquivo `.env`, especialmente as relacionadas ao banco de dados.

### 4. Instalação das Dependências

- Execute o seguinte comando para instalar as dependências do Composer:

```bash
composer install
```

### 5. Execução do Servidor

- Inicie o servidor embutido do PHP usando o Slim:

```bash
php -S localhost:8000 -t public
```

A API estará acessível em <http://localhost:8000>.

## Estrutura do Banco de Dados

### Tabelas

#### Usuários

- **Nome da Tabela:** `users`

| Campo         | Tipo            | Descrição                                       |
| ------------- | --------------- | ----------------------------------------------- |
| id            | INT PRIMARY KEY | Identificador único do usuário                  |
| name          | VARCHAR(200)    | Nome do usuário                                 |
| email         | VARCHAR(200)    | Endereço de e-mail do usuário                   |
| password      | VARCHAR(200)    | Senha do usuário (formato de HASH)              |
| access_token  | VARCHAR(400)    | Token de acesso do usuário                      |
| created_at    | TIMESTAMP       | Data e hora de criação do registro              |
| updated_at    | TIMESTAMP       | Data e hora da última atualização do registro   |

### Relacionamentos

- Não há relacionamentos complexos na tabela de usuários por enquanto.

## Uso da API

- Registro de Usuário:

  - Endpoint: `POST /api/register`
  - Corpo da Requisição:

  ```json
  {
    "user": {
        "id": 1,
        "name": "Nome do Usuário",
        "email": "usuario@example.com",
        "password": "Senha do usuário em formato de HASH",
        "access_token": "Token de Acesso que terá inicialmente seu valor como NULL"
    },
    "message": "Usuário cadastrado com sucesso.",
    "statusCode": 201
  }
  ```

  ```bash
  curl -X POST -F "name=Nome do Usuário" -F "email=<usuario@example.com>" -F "password=Senha do usuário" <http://localhost:8000/api/register>
  ```

- Login:

  - Endpoint: `POST /api/login`
  - Corpo da Requisição:

  ```json
  {
    "user": {
        "id": 1,
        "name": "Nome do Usuário",
        "email": "usuario@example.com",
        "password": "Senha do usuário em formato de HASH",
        "access_token": "Token de Acesso"
    },
    "message": "Login bem-sucedido.",
    "statusCode": 200
  }
  ```

  ```bash
  curl -X POST -F "email=<usuario@example.com>" -F "password=Senha do usuário" <http://localhost:8000/api/login>
  ```

- Alterar Dados da Conta:
  - Endpoint: `POST /api/update/{id}`
  - Corpo da Requisição:

  ```json
  {
    "message": "Dados do usuário alterado com sucesso.",
    "statusCode": 200
  }
  ```

  ```bash
  curl -X POST -F "name=Novo Nome do Usuário" -F "email=novoemail@example.com" -F "password=Nova Senha" http://localhost:8000/api/update/1
  ```

- Deletar Conta:
  - Endpoint: `DELETE /api/delete/{id}`
  - Corpo da Requisição:

  ```json
  {
    "message": "Usuário deletado com sucesso.",
    "statusCode": 200
  }
  ```

  ```bash
  curl -X DELETE -F http://localhost:8000/api/update/1
  ```

### Rotas Privadas

- Obter Informações das rotas privadas:
  - Endpoint: `POST /api/validate`

  ```json
  {
    "user": {
        "id": 1,
        "name": "Nome do Usuário",
        "email": "usuario@example.com",
        "password": "Senha do usuário em formato de HASH",
        "access_token": "Token de Acesso"
    },
    "validated": true,
    "statusCode": 200
  }
  ```

  ```bash
  curl -X POST -F "access_token=SeuTokenDeAcesso" http://localhost:8000/api/validate
  ```

## Contribuição

- Se você deseja contribuir para o projeto, crie uma branch, faça suas alterações e envie um pull request.
- Reporte problemas ou sugira melhorias através das "Issues".

## Licença

Este projeto é licenciado sob a [LICENSE](LICENSE). Sinta-se à vontade para usar, modificar e distribuir conforme necessário.
