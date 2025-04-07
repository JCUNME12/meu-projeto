<?php require_once 'includes/header.php'; ?>
<?php require_once 'includes/conexao.php'; ?>

<h2 class="mb-4">Cadastrar Novo Filme</h2>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $diretor = $_POST['diretor'] ?? '';
    $ano = $_POST['ano_lancamento'] ?? '';
    $genero = $_POST['genero'] ?? '';
    $duracao = $_POST['duracao'] ?? '';
    $sinopse = $_POST['sinopse'] ?? '';

    // Validação básica
    $errors = [];
    if (empty($titulo)) $errors[] = "Título é obrigatório";
    if (empty($diretor)) $errors[] = "Diretor é obrigatório";
    if (!is_numeric($ano) || $ano < 1888) $errors[] = "Ano inválido";
    if (!is_numeric($duracao) || $duracao <= 0) $errors[] = "Duração inválida";

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO filmes (titulo, diretor, ano_lancamento, genero, duracao, sinopse) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$titulo, $diretor, $ano, $genero, $duracao, $sinopse])) {
            echo '<div class="alert alert-success">Filme cadastrado com sucesso!</div>';
            // Limpar formulário
            $_POST = [];
        } else {
            echo '<div class="alert alert-danger">Erro ao cadastrar filme.</div>';
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

<form method="post" class="needs-validation" novalidate>
    <div class="mb-3">
        <label for="titulo" class="form-label">Título *</label>
        <input type="text" class="form-control" id="titulo" name="titulo" required value="<?= $_POST['titulo'] ?? '' ?>">
    </div>
    
    <div class="mb-3">
        <label for="diretor" class="form-label">Diretor *</label>
        <input type="text" class="form-control" id="diretor" name="diretor" required value="<?= $_POST['diretor'] ?? '' ?>">
    </div>
    
    <div class="row">
        <div class="col-md-3 mb-3">
            <label for="ano_lancamento" class="form-label">Ano de Lançamento *</label>
            <input type="number" class="form-control" id="ano_lancamento" name="ano_lancamento" min="1888" max="<?= date('Y')+5 ?>" required value="<?= $_POST['ano_lancamento'] ?? '' ?>">
        </div>
        
        <div class="col-md-3 mb-3">
            <label for="duracao" class="form-label">Duração (min) *</label>
            <input type="number" class="form-control" id="duracao" name="duracao" min="1" required value="<?= $_POST['duracao'] ?? '' ?>">
        </div>
        
        <div class="col-md-6 mb-3">
            <label for="genero" class="form-label">Gênero *</label>
            <select class="form-select" id="genero" name="genero" required>
                <option value="">Selecione...</option>
                <option value="Ação" <?= ($_POST['genero'] ?? '') == 'Ação' ? 'selected' : '' ?>>Ação</option>
                <option value="Comédia" <?= ($_POST['genero'] ?? '') == 'Comédia' ? 'selected' : '' ?>>Comédia</option>
                <option value="Drama" <?= ($_POST['genero'] ?? '') == 'Drama' ? 'selected' : '' ?>>Drama</option>
                <option value="Ficção Científica" <?= ($_POST['genero'] ?? '') == 'Ficção Científica' ? 'selected' : '' ?>>Ficção Científica</option>
                <option value="Terror" <?= ($_POST['genero'] ?? '') == 'Terror' ? 'selected' : '' ?>>Terror</option>
                <option value="Romance" <?= ($_POST['genero'] ?? '') == 'Romance' ? 'selected' : '' ?>>Romance</option>
                <option value="Animação" <?= ($_POST['genero'] ?? '') == 'Animação' ? 'selected' : '' ?>>Animação</option>
                <option value="Documentário" <?= ($_POST['genero'] ?? '') == 'Documentário' ? 'selected' : '' ?>>Documentário</option>
            </select>
        </div>
    </div>
    
    <div class="mb-3">
        <label for="sinopse" class="form-label">Sinopse</label>
        <textarea class="form-control" id="sinopse" name="sinopse" rows="3"><?= $_POST['sinopse'] ?? '' ?></textarea>
    </div>
    
    <button type="submit" class="btn btn-primary">Cadastrar Filme</button>
</form>

<script src="js/script.js"></script>
<?php require_once 'includes/footer.php'; ?>