# Goup back-end

## Instalando dependencias
```
composer install
```

### Configurando o projeto
Renomeie o arquivo /.env.example para .env e em seguida edite-o com suas informações do banco de dados, apos essa configuração você precisará rodar os seguintes comando na raiz do projeto.

para gerar uma key:
```
php artisan key:generate
```

para criar as tabelas do banco de dados
```
php artisan migrate
```

para configurar o passport:
```
php artisan passport:install
```

para rodar o projeto:
```
php artisan serve
```
