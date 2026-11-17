# Mini Loja com PHP e SQLite

Projeto de CRUD completo (cadastrar, listar, editar e excluir produtos) desenvolvido em PHP utilizando banco de dados SQLite criado automaticamente.

## Arquivos do Projeto

- `conexao.php`: Conecta ao SQLite e cria o arquivo `loja.sqlite` e a tabela `produtos` automaticamente.
- `index.php`: Lista os produtos cadastrados com barra de busca por nome ou categoria.
- `form.php`: Formulário para cadastrar novos produtos ou editar produtos existentes.
- `excluir.php`: Remove um produto do banco de dados a partir do seu ID.

## Como Executar no XAMPP

1. Copie todos os arquivos para uma pasta dentro de `C:\xampp\htdocs\` (por exemplo, `C:\xampp\htdocs\mini-loja`).
2. Abra o painel de controle do **XAMPP** e inicie o servidor **Apache**.
3. Acesse `http://localhost/mini-loja` no navegador.
