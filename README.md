# DESAFIO BACKEND EMPRESTA

Projeto backend Desafio Empresta. 

## Core
Laravel 7.x

## Instalação básica

```
Ter instalado PHP >= 7.0
Ter instalado Composer
```

### Extensões necessárias

```
BCMath PHP Extension
Ctype PHP Extension
Fileinfo PHP extension
JSON PHP Extension
Mbstring PHP Extension
OpenSSL PHP Extension
PDO PHP Extension
Tokenizer PHP Extension
XML PHP Extension
Curl Extension
GD Extension
```

### Criando arquivo .env

```
sudo cp -rp .env.example .env
```

### Comandos básicos para iniciar o projeto

Comandos principais

```
composer install
php artisan key:generate
php artisan storage:link
```

Comandos Auxiliares (caso necessário)
```
php artisan config:cache
php artisan cache:clear
php artisan config:clear
```

### Coleção no Postman

As rotas são autenticadas por um Basic, para conseguir o token entrar em contato com admin do projeto

```
https://www.getpostman.com/collections/9e07dcb77bb33bf929d3
```

### Servidor local e Rotas

Para iniciar o servidor de desenvolvimento do Laravel, basta rodar o comando abaixo.
Por padrão vem configurado para ser executado no host localhost e na porta 8000. 
Isso permite que você acesso sua aplicação Laravel através da url http://localhost:8000

```
php artisan serve
```

Rotas:
```
(GET) /api/convenios
(GET) /api/instituicoes
(POST) /api/credito/disponivel
```

### Validação da rota /credito/disponivel

```
valor_emprestimo: mínimo 1, máximo 9999.90, aceita o ponto e duas casas depois do ponto | campo obrigatório
instituicoes: array com mínimo 1 item | campo não obrigatório
convenios: array com mínimo 1 item | campo não obrigatório
parcelas: Número inteiro e divisível por 12 | campo não obrigatório
```


