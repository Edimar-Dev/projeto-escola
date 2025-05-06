<?php require_once('./index.php'); ?>

<div>
    <h3>Ver Alunos por Turma</h3>

    <form method="GET">
        <label for="turma_id">Selecione a turma:</label>
        <select name="turma_id" id="turma_id" required>
            <option value="">Selecione</option>
            <?php
            $caminhoTurmas = __DIR__ . '/../data/turmas.json';
            if (file_exists($caminhoTurmas)) {
                $turmas = json_decode(file_get_contents($caminhoTurmas), true);
                foreach ($turmas as $turma) {
                    $selected = (isset($_GET['turma_id']) && $_GET['turma_id'] === $turma['id']) ? 'selected' : '';
                    echo "<option value=\"{$turma['id']}\" $selected>" . htmlspecialchars($turma['nome']) . "</option>";
                }
            }
            ?>
        </select>
        <button type="submit">Ver alunos</button>
    </form>
</div>

<?php
if (isset($_GET['turma_id']) && $_GET['turma_id'] !== '') {
    $turmaId = $_GET['turma_id'];

    $caminhoAlunos = __DIR__ . '/../data/alunos.json';
    if (file_exists($caminhoAlunos)) {
        $alunos = json_decode(file_get_contents($caminhoAlunos), true);
        $alunosDaTurma = array_filter($alunos, fn($a) => $a['turma_id'] === $turmaId);

        if (!empty($alunosDaTurma)) {
            echo "<h4>Alunos da turma selecionada:</h4><ul>";
            foreach ($alunosDaTurma as $aluno) {
                echo "<li>" . htmlspecialchars($aluno['nome']) . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Nenhum aluno cadastrado nessa turma.</p>";
        }
    } else {
        echo "<p>Nenhum aluno cadastrado ainda.</p>";
    }
}
?>

<?php require_once('../includes/footer.php'); ?>