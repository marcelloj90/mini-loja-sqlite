<?php
require 'conexao.php';

$id = $_GET['id'] ?? null;
$produto = ['nome' => '', 'categoria' => '', 'descricao' => '', 'preco' => '', 'estoque' => 0];

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->execute([$id]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $categoria = trim($_POST['categoria']);
    $descricao = trim($_POST['descricao']);
    $preco = (float) str_replace(',', '.', $_POST['preco']);
    $estoque = (int) $_POST['estoque'];

    if ($id) {
        $stmt = $pdo->prepare("UPDATE produtos SET nome = ?, categoria = ?, descricao = ?, preco = ?, estoque = ? WHERE id = ?");
        $stmt->execute([$nome, $categoria, $descricao, $preco, $estoque, $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO produtos (nome, categoria, descricao, preco, estoque) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nome, $categoria, $descricao, $preco, $estoque]);
    }

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $id ? 'Editar Produto' : 'Novo Produto' ?> - Mini Loja</title>
    <style>
        :root {
            --fundo: #f4f6f9;
            --superficie: #ffffff;
            --primaria: #10b981;
            --texto: #1e293b;
            --borda: #e2e8f0;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: system-ui, -apple-system, sans-serif; background: var(--fundo); color: var(--texto); line-height: 1.5; }
        .container { max-width: 960px; margin: 0 auto; padding: 0 20px; }
        .topo { background: #0f172a; color: #fff; padding: 18px 0; margin-bottom: 32px; }
        .topo h1 { font-size: 1.4rem; }
        .flex-between { display: flex; justify-content: space-between; align-items: center; }
        .card { background: var(--superficie); border-radius: 10px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid var(--borda); max-width: 560px; margin: 0 auto; }
        .card h2 { margin-bottom: 20px; font-size: 1.25rem; }
        .campo { margin-bottom: 16px; }
        label { display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.9rem; }
        input, textarea { width: 100%; padding: 10px 12px; border: 1px solid var(--borda); border-radius: 6px; font-size: 1rem; font-family: inherit; }
        input:focus, textarea:focus { outline: 2px solid var(--primaria); border-color: transparent; }
        .linha-dupla { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .btn { display: inline-block; padding: 10px 18px; border-radius: 6px; text-decoration: none; font-size: 0.9rem; font-weight: 600; border: none; cursor: pointer; }
        .btn:hover { opacity: 0.9; }
        .btn-primario { background: var(--primaria); color: #fff; }
        .btn-secundario { background: #334155; color: #fff; }
        .botoes-form { display: flex; gap: 10px; margin-top: 20px; }
    </style>
</head>
<body>
    <header class="topo">
        <div class="container flex-between">
            <h1>Mini Loja SQLite</h1>
            <a href="index.php" class="btn btn-secundario">Voltar à Lista</a>
        </div>
    </header>

    <main class="container">
        <section class="card">
            <h2><?= $id ? 'Editar Produto #' . $id : 'Cadastrar Novo Produto' ?></h2>

            <form method="POST">
                <div class="campo">
                    <label for="nome">Nome do Produto</label>
                    <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" required>
                </div>

                <div class="campo">
                    <label for="categoria">Categoria</label>
                    <input type="text" id="categoria" name="categoria" value="<?= htmlspecialchars($produto['categoria']) ?>" placeholder="Ex: Informática, Papelaria" required>
                </div>

                <div class="campo">
                    <label for="descricao">Descrição (opcional)</label>
                    <textarea id="descricao" name="descricao" rows="3"><?= htmlspecialchars($produto['descricao'] ?? '') ?></textarea>
                </div>

                <div class="linha-dupla">
                    <div class="campo">
                        <label for="preco">Preço (R$)</label>
                        <input type="number" step="0.01" id="preco" name="preco" value="<?= htmlspecialchars($produto['preco']) ?>" required>
                    </div>

                    <div class="campo">
                        <label for="estoque">Estoque</label>
                        <input type="number" id="estoque" name="estoque" value="<?= htmlspecialchars($produto['estoque']) ?>" required>
                    </div>
                </div>

                <div class="botoes-form">
                    <button type="submit" class="btn btn-primario">Salvar Produto</button>
                    <a href="index.php" class="btn btn-secundario">Cancelar</a>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
