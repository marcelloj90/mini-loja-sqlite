<?php
require 'conexao.php';

$busca = trim($_GET['busca'] ?? '');

if ($busca !== '') {
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE nome LIKE ? OR categoria LIKE ? ORDER BY id DESC");
    $stmt->execute(["%$busca%", "%$busca%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM produtos ORDER BY id DESC");
}

$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Loja SQLite</title>
    <style>
        :root {
            --fundo: #f4f6f9;
            --superficie: #ffffff;
            --primaria: #10b981;
            --texto: #1e293b;
            --texto-suave: #64748b;
            --borda: #e2e8f0;
            --editar: #3b82f6;
            --excluir: #ef4444;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: system-ui, -apple-system, sans-serif; background: var(--fundo); color: var(--texto); line-height: 1.5; }
        .container { max-width: 960px; margin: 0 auto; padding: 0 20px; }
        .topo { background: #0f172a; color: #fff; padding: 18px 0; margin-bottom: 32px; }
        .topo h1 { font-size: 1.4rem; }
        .flex-between { display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; }
        .card { background: var(--superficie); border-radius: 10px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid var(--borda); }
        .cabecalho-lista { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; gap: 16px; flex-wrap: wrap; }
        .form-busca { display: flex; gap: 8px; }
        .form-busca input { padding: 8px 12px; border: 1px solid var(--borda); border-radius: 6px; font-size: 0.9rem; width: 220px; }
        .btn { display: inline-block; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 0.9rem; font-weight: 600; border: none; cursor: pointer; }
        .btn:hover { opacity: 0.9; }
        .btn-primario { background: var(--primaria); color: #fff; }
        .btn-secundario { background: #334155; color: #fff; }
        .btn-editar { background: var(--editar); color: #fff; padding: 6px 12px; font-size: 0.85rem; }
        .btn-excluir { background: var(--excluir); color: #fff; padding: 6px 12px; font-size: 0.85rem; }
        .tabela-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid var(--borda); }
        th { background: #f8fafc; color: var(--texto-suave); font-size: 0.85rem; text-transform: uppercase; }
        .desc { font-size: 0.85rem; color: var(--texto-suave); display: block; }
        .acoes { display: flex; gap: 8px; }
        .vazio { color: var(--texto-suave); padding: 20px 0; }
    </style>
</head>
<body>
    <header class="topo">
        <div class="container flex-between">
            <h1>Mini Loja SQLite</h1>
            <a href="form.php" class="btn btn-primario">+ Novo Produto</a>
        </div>
    </header>

    <main class="container">
        <section class="card">
            <div class="cabecalho-lista">
                <h2>Produtos Cadastrados (<?= count($produtos) ?>)</h2>
                <form method="GET" class="form-busca">
                    <input type="text" name="busca" placeholder="Buscar produto ou categoria..." value="<?= htmlspecialchars($busca) ?>">
                    <button type="submit" class="btn btn-secundario">Buscar</button>
                    <?php if ($busca !== ''): ?>
                        <a href="index.php" class="btn btn-secundario">Limpar</a>
                    <?php endif; ?>
                </form>
            </div>

            <?php if (count($produtos) === 0): ?>
                <p class="vazio">Nenhum produto encontrado.</p>
            <?php else: ?>
                <div class="tabela-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Produto</th>
                                <th>Categoria</th>
                                <th>Preço</th>
                                <th>Estoque</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($produtos as $p): ?>
                                <tr>
                                    <td>#<?= $p['id'] ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($p['nome']) ?></strong>
                                        <?php if (!empty($p['descricao'])): ?>
                                            <span class="desc"><?= htmlspecialchars($p['descricao']) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($p['categoria']) ?></td>
                                    <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
                                    <td><?= (int)$p['estoque'] ?> un.</td>
                                    <td class="acoes">
                                        <a href="form.php?id=<?= $p['id'] ?>" class="btn btn-editar">Editar</a>
                                        <a href="excluir.php?id=<?= $p['id'] ?>" class="btn btn-excluir" onclick="return confirm('Deseja realmente excluir este produto?')">Excluir</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
