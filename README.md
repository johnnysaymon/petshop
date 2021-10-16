# Sistema de Gestão de Itens do Serviço de Assistência Técnica

## Dependências

- Docker v20.10.8
- Docker Compose 1.26.2

ou

- Apache 2 (com rewrite modo habilitado);
- PHP 8.0 (com PDO);
- Mysql 8;
- Composer 2.0;


## Configuração com Docker

1. Fazer uma cópia do arquivo '.env-example' e renomear para '.env' e editar dados;
2. Baixar as dependências com o comando `docker-compose run --rm composer update`;


## Levantar Servidor

Antes é necessário checar se a porta 8000 já não está sendo usada por outro recurso.

`docker-compose up -d www`


## Derrubar Servidor

`docker-compose down`


## Testes

Para rodar os testes unitários usar o comando:

`docker-compose rum --rm tests`


## Mais informações

- [API](doc/api.md)
- [Sobre o Projeto](doc/about.md)
