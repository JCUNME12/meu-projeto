<?php require_once 'includes/header.php'; ?>
<?php require_once 'includes/conexao.php'; ?>

<?php
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM filmes WHERE id = ?");
$stmt->execute([$id]);
$filme = $stmt->fetch();

if (!$filme) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $diretor = $_POST['diretor'] ?? '';
    $ano = $_POST['ano_lancamento'] ?? '';
    $genero = $_POST['genero'] ?? '';
    $duracao = $_POST['duracao'] ?? '';
    $sinopse = $_POST['sinopse'] ?? '';

    // Validação
    $errors = [];
    if (empty($titulo)) $errors[] = "Título é obrigatório";
    if (empty($diretor)) $errors[] = "Diretor é obrigatório";
    if (!is_numeric($ano) || $ano < 1888) $errors[] = "Ano inválido";
    if (!is_numeric($duracao) || $duracao <= 0) $errors[] = "Duração inválida";

    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE filmes SET titulo = ?, diretor = ?, ano_lancamento = ?, genero = ?, duracao = ?, sinopse = ? WHERE id = ?");
        if ($stmt->execute([$titulo, $diretor, $ano, $genero, $duracao, $sinopse, $id])) {
            echo '<div class="alert alert-success">Filme atualizado com sucesso!</div>';
            // Atualizar os dados exibidos
            $filme = [
                'titulo' => $titulo,
                'diretor' => $diretor,
                'ano_lancamento' => $ano,
                'genero' => $genero,
                'duracao' => $duracao,
                'sinopse' => $sinopse
            ];
        } else {
            echo '<div class="alert alert-danger">Erro ao atualizar filme.</div>';
        }
    } else {
        echo '<div class="alert alert-danger"><ul>';
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo '</ul></div>';
    }
}
?>

<h2 class="mb-4">Editar Filme</h2>

<form method="post">
    <div class="mb-3">
        <label for="titulo" class="form-label">Título *</label>
        <input type="text" class="form-control" id="titulo" name="titulo" required value="<?= htmlspecialchars($filme['titulo']) ?>">
    </div>
    
    <div class="mb-3">
        <label for="diretor" class="form-label">Diretor *</label>
        <input type="text" class="form-control" id="diretor" name="diretor" required value="<?= htmlspecialchars($filme['diretor']) ?>">
    </div>
    
    <div class="row">
        <div class="col-md-3 mb-3">
            <label for="ano_lancamento" class="form-label">Ano de Lançamento *</label>
            <input type="number" class="form-control" id="ano_lancamento" name="ano_lancamento" min="1888" max="<?= date('Y')+5 ?>" required value="<?= $filme['ano_lancamento'] ?>">
        </div>
        
        <div class="col-md-3 mb-3">
            <label for="duracao" class="form-label">Duração (min) *</label>
            <input type="number" class="form-control" id="duracao" name="duracao" min="1" required value="<?= $filme['duracao'] ?>">
        </div>
        
        <div class="col-md-6 mb-3">
            <label for="genero" class="form-label">Gênero *</label>
            <select class="form-select" id="genero" name="genero" required>
                <option value="">Selecione...</option>
                <option value="Ação" <?= $filme['genero'] == 'Ação' ? 'selected' : '' ?>>Ação</option>
                <option value="Comédia" <?= $filme['genero'] == 'Comédia' ? 'selected' : '' ?>>Comédia</option>
                <option value="Drama" <?= $filme['genero'] == 'Drama' ? 'selected' : '' ?>>Drama</option>
                <option value="Ficção Científica" <?= $filme['genero'] == 'Ficção Científica' ? 'selected' : '' ?>>Ficção Científica</option>
                <option value="Terror" <?= $filme['genero'] == 'Terror' ? 'selected' : '' ?>>Terror</option>
                <option value="Romance" <?= $filme['genero'] == 'Romance' ? 'selected' : '' ?>>Romance</option>
                <option value="Animação" <?= $filme['genero'] == 'Animação' ? 'selected' : '' ?>>Animação</option>
                <option value="Documentário" <?= $filme['genero'] == 'Documentário' ? 'selected' : '' ?>>Documentário</option>
            </select>
        </div>
    </div>
    
    <div class="mb-3">
        <label for="sinopse" class="form-label">Sinopse</label>
        <textarea class="form-control" id="sinopse" name="sinopse" rows="3"><?= htmlspecialchars($filme['sinopse']) ?></textarea>
    </div>
    
    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once 'includes/footer.php'; ?>