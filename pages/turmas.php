<?php require_once('./index.php'); ?>

<div>
    <h3>RELAÇÃO DE TURMAS</h3>
    <form action="../actions/TurmaController.php" method="POST">
        <input type="hidden" name="acao" value="cadastrar">
        <label for="turma">Nome da Turma:</label>
        <input type="text" name="turma" id="turma" required>
        <button type="submit">Cadastrar</button>

        <?php if (isset($_GET['erro']) && $_GET['erro'] === 'ja-existe'): ?>
            <p style="color: red;">Essa turma já foi cadastrada!</p>
        <?php endif; ?>

        <?php if (isset($_GET['sucesso'])): ?>
            <p style="color: green;">Turma cadastrada com sucesso!</p>
        <?php endif; ?>
    </form>
</div>

<?php
$caminhoArquivo = __DIR__ . '/../data/turmas.json';

if (file_exists($caminhoArquivo)) {
    $conteudo = file_get_contents($caminhoArquivo);
    $turmas = json_decode($conteudo, true);

    if (!empty($turmas)) {
        echo "<h4>📋 Lista de Turmas Cadastradas</h4>";
        echo "<table border='1' cellpadding='10' cellspacing='0'>";
        echo "<tr><th>Turma</th><th>Remover</th></tr>";

        foreach ($turmas as $turma) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($turma['nome']) . "</td>";
            echo "<td>
                <form action='../actions/TurmaController.php' method='POST' onsubmit='return confirm(\"Tem certeza que deseja excluir esta turma?\");'>
                    <input type='hidden' name='acao' value='excluir'>
                    <input type='hidden' name='id' value='" . htmlspecialchars($turma['id']) . "'>
                    <button type='submit'>Excluir</button>
                </form>
            </td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>Nenhuma turma cadastrada ainda.</p>";
    }
} else {
    echo "<p>Nenhuma turma cadastrada ainda.</p>";
}
?>

<?php require_once('../includes/footer.php'); ?>