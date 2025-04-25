<?php require_once('./index.php'); ?>

<div>
    <h3>RELAÇÃO DE MATÉRIAS</h3>
    <form action="../actions/MateriaController.php" method="POST">
        <input type="hidden" name="acao" value="cadastrar">
        <label for="materia">Nome da Matéria:</label>
        <input type="text" name="materia" id="materia" required>
        <button type="submit">Cadastrar</button>

        <?php if (isset($_GET['erro']) && $_GET['erro'] === 'ja-existe'): ?>
        <p style="color: red;">Essa matéria já foi cadastrada!</p>
        <?php endif; ?>

        <?php if (isset($_GET['sucesso'])): ?>
        <p style="color: green;">Matéria cadastrada com sucesso!</p>
        <?php endif; ?>
    </form>
</div>
<?php

$caminhoArquivo = __DIR__ . '/../data/materias.json';

if (file_exists($caminhoArquivo)) {
    $conteudo = file_get_contents($caminhoArquivo);
    $materias = json_decode($conteudo, true);

    if (!empty($materias)) {
        echo "<ul>";
        foreach ($materias as $materia) {
            echo "<li>" . htmlspecialchars($materia['nome']) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Nenhuma matéria cadastrada ainda.</p>";
    }
} else {
    echo "<p>Nenhuma matéria cadastrada ainda.</p>";
}
?>

<?php require_once('../includes/footer.php')?>