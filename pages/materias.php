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
        echo "<h4>📘 Lista de Matérias Cadastradas</h4>";
        echo "<table border='1' cellpadding='10' cellspacing='0'>";
        echo "<tr><th>Matéria</th><th>Remover</th></tr>";

        foreach ($materias as $materia) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($materia['nome']) . "</td>";
            echo "<td>
                <form action='../actions/MateriaController.php' method='POST' onsubmit='return confirm(\"Tem certeza que deseja excluir esta matéria?\");'>
                    <input type='hidden' name='acao' value='excluir'>
                    <input type='hidden' name='id' value='" . htmlspecialchars($materia['id']) . "'>
                    <button type='submit'>Excluir</button>
                </form>
            </td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>Nenhuma matéria cadastrada ainda.</p>";
    }
} else {
    echo "<p>Nenhuma matéria cadastrada ainda.</p>";
}
?>

<?php require_once('../includes/footer.php'); ?>