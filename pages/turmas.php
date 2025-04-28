<?php require_once('./index.php'); ?>

<div>
    <h3>TURMAS</h3>
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
        echo "<ul>";
        foreach ($turmas as $turma) {
            echo "<li>" . htmlspecialchars($turma['nome']) . 
                " <form action='../actions/TurmaController.php' method='POST' style='display:inline;'>
                    <input type='hidden' name='acao' value='excluir'>
                    <input type='hidden' name='id' value='" . htmlspecialchars($turma['id']) . "'>
                    <button type='submit' onclick='return confirm(\"Tem certeza que deseja excluir esta turma?\")'>Excluir</button>
                   </form>
                </li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Nenhuma turma cadastrada ainda.</p>";
    }
} else {
    echo "<p>Nenhuma turma cadastrada ainda.</p>";
}
?>


<?php require_once('../includes/footer.php')?>