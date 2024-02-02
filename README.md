## Tecnologias/Pacotes

- [Laravel](https://laravel.com/docs/master)

## Dependências

- PHP 8 ou Maior
- Composer
- Docker
- Docker Compose

## Como Usar?

Clone o projeto e acesse a pasta e rode os seguintes comandos

```bash
# cp .env.example .env
# composer install
# ./vendor/bin/sail up
```
Após a criação dos containers, execute o comando para gerar as migrations

```bash
# ./vendor/bin/sail artisan migrate
```
Após a criação das migrations, execute o comando abaixo para deixar o worker da fila rodando

```bash
# ./vendor/bin/sail artisan queue:work
```

Todos os emails que forem disparados estarão visíveis no Mailpit (`http://localhost:8025`)
