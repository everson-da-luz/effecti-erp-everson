# Effecti - ERP - Everson

Projeto para teste técnico. O teste consiste em desenvolver um ERP com o módulo principal sendo os contratos, aos quais podem ser vinculados serviços e clientes.

## Funcionalidades implementadas
- CRUD de clientes
- CRUD de serviços
- CRUD de contratos
- Adicionar e remover serviços (itens) no contrato
- Calcular valor total do contrato
- Opção de aplicar uma porcentagem de desconto para uma quantidade de serviços

## Tecnologias utilizadas
A aplicação foi separada em dois projetos, um sistema web (front-end) e uma API RESTFull (back-end). Para orquestrar os projetos foi utilizado Docker. Fora dos containers para o front-end e back-end, foi criado um container para o banco de dados.  
Seguem as tecnologias utilizadas.

### Sistema web (front-end)
- Vue.js 3.4
- Bootstrap 5.3

### API RESTFull (back-end)
- PHP 8.4
- Laravel 13
- Apache

### Banco de dados
- MySQL 8.4

### Outros
- Docker
- Docker Compose

Para mais informações sobre as tecnologias utilizadas, como funciona o projeto, rotas da API, leia o arquivo `documento-tecnico.md`.

## Instruções para rodar o projeto
Faça o clone do repositório:
```
git clone https://github.com/everson-da-luz/effecti-erp-everson.git
```
Será criada a pasta `effecti-erp-everson`. Acesse essa pasta:
```
cd effecti-erp-everson
```
Faça o build do projeto:
```
docker-compose build
```
Monte e suba os containers:
```
docker-compose up
```
**ATENÇÃO:** O projeto utilizará as portas 5173 e 8080 caso tenha alguma aplicação rodando nessas portas, favor desabilita-las para que tudo funcione corretamente.

Rode as migrations para criar as tabelas necessárias para a aplicação funcionar:
```
docker-compose exec api php artisan migrate
```
**Observação:** Após fazer o up para montar os containers o terminal ficará travado, abra outro terminal e acesse a pasta do projeto. Os comandos para as migrations e seeds só funcionarão dentro da pasta e somente após os containers subirem sem problemas.

Caso queira popular as tabelas com alguns dados fakes, para facilitar a visualização das telas, criei seeds para isso, basta rodar o comando:
```
docker-compose exec api php artisan db:seed
```

## Acessando a aplicação
Caso tudo ocorra bem será disponibilizado duas URLs, uma para o front-end e outra para o back-end.
- [http://localhost:5173](http://localhost:5173) - Sistema web (front-end)
- [http://localhost:8080](http://localhost:8080) - API RESTFull (back-end)