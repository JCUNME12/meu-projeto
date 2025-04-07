<?php require_once 'includes/header.php'; ?>
<?php require_once 'includes/conexao.php'; ?>

<h2 class="mb-4">Filmes Cadastrados</h2>

<?php
$stmt = $pdo->query("SELECT * FROM filmes ORDER BY titulo");
$filmes = $stmt->fetchAll();

if (count($filmes) > 0): ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Diretor</th>
                    <th>Ano</th>
                    <th>Gênero</th>
                    <th>Duração</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($filmes as $filme): ?>
                <tr>
                    <td><?= htmlspecialchars($filme['titulo']) ?></td>
                    <td><?= htmlspecialchars($filme['diretor']) ?></td>
                    <td><?= $filme['ano_lancamento'] ?></td>
                    <td><?= htmlspecialchars($filme['genero']) ?></td>
                    <td><?= $filme['duracao'] ?> min</td>
                    <td>
                        <a href="editar.php?id=<?= $filme['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                        <a href="excluir.php?id=<?= $filme['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?')">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-info">Nenhum filme cadastrado ainda.</div>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>