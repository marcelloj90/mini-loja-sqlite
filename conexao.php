<?php
try {
    $pdo = new PDO('sqlite:' . __DIR__ . '/loja.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE TABLE IF NOT EXISTS produtos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nome TEXT NOT NULL,
        categoria TEXT NOT NULL,
        descricao TEXT,
        preco REAL NOT NULL,
        estoque INTEGER NOT NULL DEFAULT 0
    )";
    $pdo->exec($sql);
} catch (PDOException $e) {
    die("Erro ao conectar com SQLite: " . $e->getMessage());
}
