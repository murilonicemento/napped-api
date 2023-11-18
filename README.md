# Napped API

## Introdução

Bem-vindo ao projeto Napped API! O Napped é uma fonte de informações sobre o mundo nerd, abrangendo séries, filmes, animes e jogos. Este README fornecerá orientações sobre como configurar, usar e contribuir para este projeto.

## Funcionalidades

- **Registro de Usuário e Login:** Os usuários podem se registrar para obter uma conta e fazer login para acessar recursos exclusivos.

- **Informações Nerd:** Fornece informações sobre séries, filmes, animes e jogos. Os usuários podem explorar detalhes, classificações e outras informações relacionadas.

## Configuração do Ambiente

### 1. Pré-requisitos

- PHP 8 ou superior
- Composer
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

## Uso da API

- Registro de Usuário:

  - Endpoint: `POST /api/register`
  - Corpo da Requisição:

  ```json
  {
    "user": {
        "id": 1,
        "name": "Nome do Usuário",
        "email": "usuario@example.com"
    },
    "message": "Usuário cadastrado com sucesso.",
    "statusCode": 201
  }
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

- Alterar Dados da Conta:
  - Endpoint: `PUT /api/update/{id}[/{name}[/{email}[/password]]`
  - Corpo da Requisição:

  ```json
  {
    "message": "Dados do usuário alterado com sucesso.",
    "statusCode": 200
  }
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

### Rotas Privadas

- Obter Informações da Home:
  - Endpoint: `POST /api/private/home`

  ```json
  {
    "success": true,
    "statusCode": 200
  }
  ```

- Obter Informações de Filmes:
  - Endpoint: `POST /api/private/movies`

  ```json
  {
    "success": true,
    "statusCode": 200
  }
  ```

- Obter Informações de Séries:
  - Endpoint: `POST /api/private/series`

  ```json
  {
    "success": true,
    "statusCode": 200
  }
  ```

- Obter Informações de Animes:
  - Endpoint: `POST /api/private/animes`

  ```json
  {
    "success": true,
    "statusCode": 200
  }
  ```

- Obter Informações de Jogos:
  - Endpoint: `POST /api/private/games`

  ```json
  {
    "success": true,
    "statusCode": 200
  }
  ```

## Contribuição

- Se você deseja contribuir para o projeto, crie uma branch, faça suas alterações e envie um pull request.
- Reporte problemas ou sugira melhorias através das "Issues".

## Licença

Este projeto é licenciado sob a [LICENSE](LICENSE). Sinta-se à vontade para usar, modificar e distribuir conforme necessário.
