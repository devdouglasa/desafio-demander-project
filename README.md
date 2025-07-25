# Painel de Gastos Parlamentares

## Desafio de projeto Demander de consumo de API de deputados + automação de armazenamento de dados no banco com Queue Jobs no Laravel


### Tecnologias:


<img width=50 src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/laravel/laravel-original.svg" /> &nbsp;&nbsp;&nbsp;&nbsp;
<img width=50 src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/php/php-original.svg" /> &nbsp;&nbsp;&nbsp;&nbsp;
<img width=50 src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/mysql/mysql-original-wordmark.svg" />&nbsp;&nbsp;&nbsp;&nbsp;
<img width=50 src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/docker/docker-original-wordmark.svg" />&nbsp;&nbsp;&nbsp;&nbsp;
<img width=50 src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/amazonwebservices/amazonwebservices-plain-wordmark.svg" />&nbsp;&nbsp;&nbsp;&nbsp;
<img width=50 src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/bootstrap/bootstrap-original.svg" />
          
#

### Iniciando o projeto:
Instale as dependencias do projeto:
```
composer install
```
Copie o arquivo .env:
```
cp .env-example .env
```
Configure o .env para o seu banco de dados:
```
DB_CONNECTION=mysql // se utilizar o sqlite, comente as linhas abaixo
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=root
```
Gerar o app key do laravel:
```
php artisan key:generate
```
Crie as migrations:
```
php artisan migrate
```
Inicie o projeto:
```
php artisan serve
```

A primeira vez que iniciar irá demorar um pouco pois o banco de dados será sincronizado com a API da camara.

#

Link do projeto rodando: http://15.228.99.228/

#

### Desenvolvido por Douglas