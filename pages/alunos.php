<?php require_once('./index.php'); ?>

<div>
    <h3>RELAÇÃO DE ALUNOS</h3>
    <form action="../actions/AlunoController.php" method="POST">
        <input type="hidden" name="acao" value="cadastrar">
        <label for="aluno">Nome do Aluno:</label>
        <input type="text" name="aluno" id="aluno" required>
        <button type="submit">Cadastrar</button>

        <?php if (isset($_GET['erro']) && $_GET['erro'] === 'ja-existe'): ?>
            <p style="color: red;">Esse aluno já foi cadastrado!</p>
        <?php endif; ?>

        <?php if (isset($_GET['sucesso'])): ?>
            <p style="color: green;">Aluno cadastrado com sucesso!</p>
        <?php endif; ?>

        <?php if (isset($_GET['excluido'])): ?>
            <p style="color: green;">Aluno excluído com sucesso!</p>
        <?php endif; ?>
    </form>
</div>

<hr>

<?php
$caminhoArquivo = __DIR__ . '/../data/alunos.json';

if (file_exists($caminhoArquivo)) {
    $conteudo = file_get_contents($caminhoArquivo);
    $alunos = json_decode($conteudo, true);

    if (!empty($alunos)) {
        echo "<ul>";
        foreach ($alunos as $aluno) {
            echo "<li>";
            echo htmlspecialchars($aluno['nome']);
            echo " <form action='../actions/AlunoController.php' method='POST' style='display:inline;'>
                    <input type='hidden' name='acao' value='excluir'>
                    <input type='hidden' name='id' value='" . htmlspecialchars($aluno['id']) . "'>
                    <button type='submit' onclick='return confirm(\"Tem certeza que deseja excluir este aluno?\")'>Excluir</button>
                </form>
                </li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Nenhum aluno cadastrado ainda.</p>";
    }
} else {
    echo "<p>Nenhum aluno cadastrado ainda.</p>";
}
?>

<?php require_once('../includes/footer.php'); ?>