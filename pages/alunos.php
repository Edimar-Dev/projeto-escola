<?php require_once('./index.php'); ?>

<div>
    <h3>RELAÇÃO DE ALUNOS</h3>
    <form action="../actions/AlunoController.php" method="POST">
        <input type="hidden" name="acao" value="cadastrar">
        
        <label for="aluno">Nome do Aluno:</label>
        <input type="text" name="aluno" id="aluno" required>

        <label for="turma">Turma:</label>
        <select name="turma_id" id="turma" required>
            <option value="">Selecione uma turma</option>
            <?php
            $caminhoTurmas = __DIR__ . '/../data/turmas.json';
            if (file_exists($caminhoTurmas)) {
                $turmas = json_decode(file_get_contents($caminhoTurmas), true);
                foreach ($turmas as $turma) {
                    echo "<option value=\"{$turma['id']}\">" . htmlspecialchars($turma['nome']) . "</option>";
                }
            }
            ?>
        </select>

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

<?php
$caminhoAlunos = __DIR__ . '/../data/alunos.json';
$caminhoTurmas = __DIR__ . '/../data/turmas.json';

$alunos = file_exists($caminhoAlunos) ? json_decode(file_get_contents($caminhoAlunos), true) : [];
$turmas = file_exists($caminhoTurmas) ? json_decode(file_get_contents($caminhoTurmas), true) : [];

$turmasMap = [];
foreach ($turmas as $turma) {
    $turmasMap[$turma['id']] = $turma['nome'];
}

if (!empty($alunos)) {
    echo "<ul>";
    foreach ($alunos as $aluno) {
        $nomeAluno = htmlspecialchars($aluno['nome']);
        $nomeTurma = isset($turmasMap[$aluno['turma_id']]) ? htmlspecialchars($turmasMap[$aluno['turma_id']]) : 'Turma não encontrada';

        echo "<li>{$nomeAluno} - {$nomeTurma}";
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
?>

<?php require_once('../includes/footer.php'); ?>