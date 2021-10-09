# Sobre o Projeto

O projeto foi desenvolvido para demonstrar minhas habilidades no desenvolvimento de software para web em um curto espaço de tempo.


## Objetivo

Criar uma API para o cadastro de Categorias que poderá ter uma quantidade ideterminada de atributos e Itens que deverão ser associados as categorias e definir valores para cada atributo. Desejavel criar também uma interface WEB.


## Arquitetura

Optei por usar uma leve variação da Arquitetura Limpa proposta por Robert C. Martin. A variação mecionada foi adotada para tornar o processo mais rápido.


## Modelagem

Dado que o problema estava em aberto, sem muitos detalhes e que a elaboração de suposições era esperada, então optei por adotar uma modelagem flexível para aceitar futuras modificações, são elas:

- Existem duas entidades principais que são Category (Categoria) e Item;
- Cada uma das entidades principais aceita uma infinidade de atributos;
- O diferencial dos atributos de Item é que eles possuem relação com os atributos da Categoria na qual é associado;


## Ferramenta de Terceiros

Como o objetivo principal do projeto é demonstrar meu conhecimento na área, optei por usar o mínimo possível de recursos de terceiros, me permitindo apenas utilizar as seguintes ferramentas:

- [Slim](https://www.slimframework.com/) - para facilitar o controle das rotas;
- [Twig](https://twig.symfony.com/) - para gerar o HTML de algumas páginas;
- [PHP-DI](https://php-di.org/) - para resolver dependências.


## O que faltou concluir

Dado o objetivo inicial, os seguintes itens não foram concluidos por conta do prazo:

- Design;
- CSS;
- Recurso para adição e consulta de Items via interface WEB (mas está funcional via API);


## O que faria com mais tempo

- Testes;
- Adequaria o sistema de geração de ID das entidades para UUID;
- Colocaria mais informações no retorno da API;
- Recurso de edição e exclusão dos dados;
- Filtraria os erros para não exibir mensagens;
- Tornaria o retorno de erros mais informativos;
- Criaria um log de erros;
- Adicionaria um log das ações do usuário.