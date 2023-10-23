# README: Projeto Napped API

## Introdução

Bem-vindo ao projeto Napped API! O Napped é uma fonte de informações sobre o mundo nerd, abrangendo séries, filmes, animes e jogos. Este README fornecerá orientações sobre como configurar, usar e contribuir para este projeto.

## Funcionalidades

- **Registro de Usuário e Login:** Os usuários podem se registrar para obter uma conta e fazer login para acessar recursos exclusivos.

- **Informações Nerd:** Fornece informações sobre séries, filmes, animes e jogos. Os usuários podem explorar detalhes, classificações e outras informações relacionadas.

## Configuração do Ambiente

### 1. Pré-requisitos

- PHP 7.4 ou superior
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
    "name": "Nome do Usuário",
    "email": "usuario@example.com",
    "password": "senha123"
  }
  ```

- Login:

  - Endpoint: `POST /api/login`
  - Corpo da Requisição:

  ```json
  {
    "email": "usuario@example.com",
    "password": "senha123"
  }
  ```

- Obter Informações de Séries:

  - Endpoint: GET /api/series

- Obter Informações de Filmes:
  - Endpoint: GET /api/filmes

- Obter Informações de Animes:
  - Endpoint: GET /api/animes

- Obter Informações de Jogos:
  - Endpoint: GET /api/jogos

## Contribuição

- Se você deseja contribuir para o projeto, crie uma branch, faça suas alterações e envie um pull request.
- Reporte problemas ou sugira melhorias através das "Issues".

## Licença

Este projeto é licenciado sob a [LICENSE](LICENSE). Sinta-se à vontade para usar, modificar e distribuir conforme necessário.
