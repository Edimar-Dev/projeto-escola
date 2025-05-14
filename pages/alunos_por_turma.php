<?php require_once('./index.php'); ?>

<h2>👨‍🎓 Alunos por Turma</h2>

<?php

$caminhoTurmas = __DIR__ . '/../data/turmas.json';
$turmas = file_exists($caminhoTurmas) ? json_decode(file_get_contents($caminhoTurmas), true) : [];


$turmaSelecionadaId = $_GET['turma_id'] ?? ($turmas[0]['id'] ?? '');


$caminhoAlunos = __DIR__ . '/../data/alunos.json';
$alunos = file_exists($caminhoAlunos) ? json_decode(file_get_contents($caminhoAlunos), true) : [];
?>

<form method="GET" style="margin-bottom: 20px;">
    <label for="turma_id">Selecione a turma:</label>
    <select name="turma_id" id="turma_id" onchange="this.form.submit()">
        <option value="">Selecione</option>
        <?php
        foreach ($turmas as $turma) {
            $selected = ($turmaSelecionadaId === $turma['id']) ? 'selected' : '';
            echo "<option value=\"{$turma['id']}\" $selected>" . htmlspecialchars($turma['nome']) . "</option>";
        }
        ?>
    </select>
    <noscript><button type="submit">Ver alunos</button></noscript>
</form>

<?php
if ($turmaSelecionadaId !== '') {

    $nomeTurma = '';
    foreach ($turmas as $turma) {
        if ($turma['id'] === $turmaSelecionadaId) {
            $nomeTurma = $turma['nome'];
            break;
        }
    }


    $alunosDaTurma = array_filter($alunos, fn($a) => $a['turma_id'] === $turmaSelecionadaId);

    if (!empty($alunosDaTurma)) {
        echo "<h3>📚 Turma: " . htmlspecialchars($nomeTurma) . "</h3>";
        echo "<table border='1' cellpadding='8' cellspacing='0'>";
        echo "<tr><th>Aluno</th><th>Turma</th><th>Remover</th></tr>";

        foreach ($alunosDaTurma as $aluno) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($aluno['nome']) . "</td>";
            echo "<td>" . htmlspecialchars($nomeTurma) . "</td>";
            echo "<td>
                <form method='POST' action='../actions/DesvincularAlunoController.php' onsubmit=\"return confirm('Deseja realmente desvincular este aluno da turma?');\" style='display:inline;'>
                    <input type='hidden' name='aluno_id' value='{$aluno['id']}'>
                    <button type='submit'>Desvincular</button>
                </form>
            </td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>⚠ Nenhum aluno cadastrado nessa turma.</p>";
    }
}
?>

<?php require_once('../includes/footer.php'); ?>