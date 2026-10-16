# Sistema de Gestão de Estoque

Projeto em PHP e MariaDB desenvolvido para controlar produtos e movimentações de estoque.

O código segue o padrão MVC: `Model` acessa o banco, `Controller` processa as ações e `View` apresenta as páginas.

## Instalação

1. Inicie o Apache e o MySQL no XAMPP.
2. Importe o arquivo `DB/saep_db.sql` no phpMyAdmin.
3. Acesse `http://localhost/saep.github.io/`.

## Acesso de demonstração

- E-mail: `rafa@saep.com`
- Senha: `123456`

## Funções disponíveis

- Login e logout.
- Cadastro, busca, edição e exclusão de produtos.
- Entrada e saída de estoque.
- Alerta quando uma saída deixa o estoque abaixo do mínimo.
- Histórico de movimentações com data e usuário responsável.
