<?php
require_once 'includes/conexao.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];

// Verificar se o filme existe
$stmt = $pdo->prepare("SELECT id FROM filmes WHERE id = ?");
$stmt->execute([$id]);
$filme = $stmt->fetch();

if (!$filme) {
    header('Location: index.php');
    exit;
}

// Excluir o filme
$stmt = $pdo->prepare("DELETE FROM filmes WHERE id = ?");
if ($stmt->execute([$id])) {
    header('Location: index.php?msg=Filme excluído com sucesso');
} else {
    header('Location: index.php?msg=Erro ao excluir filme');
}
exit;
?>