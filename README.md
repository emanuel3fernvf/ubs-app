# UBS-APP
Projeto para gerenciar a agenda de profissionais da saúde, incluindo o cadastro e atendimento de pacientes. Este sistema foi desenvolvido para atender às demandas de uma Unidade Básica de Saúde (UBS).

## Tecnologias Utilizadas
Tecnologias utilizadas:
- PHP 8.3;
- Laravel 11;
- MySQL 8;
- Redis 7;
- Docker.

Outros recursos:
- PHPMyAdmin;

## Para rodar o projeto localmente com docker
clonar o repositório:
```bash
git clone git@github.com:emanuel3fernvf/ubs-app.git
```

Acesso ao diretório do projeto:
```bash
cd ubs-app
```

Criar o arquivo `.env` a partir do `.env.example`:
```bash
cp .env.example .env
```

Criar uma rede com nome `proxy`:
```bash
docker network create proxy
```

Subir os containers docker:
```bash
docker compose up -d
```

Instalação das dependências:
```bash
docker compose exec app composer install
```

Criar uma chave para a aplicação:
```bash
docker compose exec app php artisan key:generate
```

Executar as migrations:
```bash
docker compose exec app php artisan migrate --force
```

Resolver erros de permissões de pastas.
<br>Acessar bash do projeto como root e conceder permissão para a pasta storage:
```bash
docker-compose exec --user=root app bash
chmod -R 777 storage/
```

Após esse processo, você poderá acessar os seguintes recursos _(caso alguma porta ou senha do arquivo `.env` tenha sido alterada, utilize a que foi definida)_:

#### WEB:
Para acesso ao projeto clique [neste link](http://localhost).

#### PHPMyAdmin:
Para acessar o PHPMyAdmin clique [neste link](http://localhost:8080).

## Informações sobre o Usuário Administrador

Ao rodar as migrations do projeto será criado um usuário administrador. Se houver um usuário com esse e-mail, ele será atualizado:

- **Nome**: Administrador
- **Email**: admin@ubsapp.com
- **Senha**: 12345678

Caso precise criar ou atualizar o usuário administrador, rode a seguinte seeder:

```bash
docker compose exec app php artisan db:seed --class=seeder_2024_06_25_102012_register_user_admin
```

Se for preciso, o usuário poderá ser alterado acessando o menu Usuário.
