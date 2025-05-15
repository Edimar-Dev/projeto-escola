<?php require_once('./index.php'); ?>

<div>
    <h3>CADASTRAR NOTAS</h3>
    <form action="../actions/NotaController.php" method="POST">
        <input type="hidden" name="acao" value="cadastrar">


        <label for="aluno_id">Aluno:</label>
        <select name="aluno_id" id="aluno_id" required>
            <option value="">Selecione</option>
            <?php
            $caminhoAlunos = __DIR__ . '/../data/alunos.json';
            if (file_exists($caminhoAlunos)) {
                $alunos = json_decode(file_get_contents($caminhoAlunos), true);
                foreach ($alunos as $aluno) {
                    echo "<option value='{$aluno['id']}' data-turma='{$aluno['turma_id']}'>" . htmlspecialchars($aluno['nome']) . "</option>";
                }
            }
            ?>
        </select>


        <label for="turma_exibida">Turma:</label>
        <input type="text" id="turma_exibida" readonly>
        <input type="hidden" name="turma_id" id="turma_id">


        <label for="materia_id">Matéria:</label>
        <select name="materia_id" id="materia_id" required>
            <option value="">Selecione</option>
            <?php
            $caminhoMaterias = __DIR__ . '/../data/materias.json';
            if (file_exists($caminhoMaterias)) {
                $materias = json_decode(file_get_contents($caminhoMaterias), true);
                foreach ($materias as $materia) {
                    echo "<option value='{$materia['id']}'>" . htmlspecialchars($materia['nome']) . "</option>";
                }
            }
            ?>
        </select>


        <label>Nota 1:</label>
            <input type="number" name="notas[]" min="0" max="10" step="0.1" required>

            <label>Nota 2:</label>
            <input type="number" name="notas[]" min="0" max="10" step="0.1" required>

            <label>Nota 3:</label>
            <input type="number" name="notas[]" min="0" max="10" step="0.1" required>

            <label>Nota 4:</label>
            <input type="number" name="notas[]" min="0" max="10" step="0.1" required>
        <button type="submit">Cadastrar Notas</button>
    </form>
</div>

<?php

$turmas = [];
$caminhoTurmas = __DIR__ . '/../data/turmas.json';
if (file_exists($caminhoTurmas)) {
    $turmas = json_decode(file_get_contents($caminhoTurmas), true);
}
?>

<script>
    const turmaNomes = <?php echo json_encode(array_column($turmas, 'nome', 'id')); ?>;

    document.getElementById('aluno_id').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const turmaId = selectedOption.getAttribute('data-turma');
        const turmaNome = turmaNomes[turmaId] || 'Turma não encontrada';

        document.getElementById('turma_exibida').value = turmaNome;
        document.getElementById('turma_id').value = turmaId;
    });
</script>

<?php require_once('../includes/footer.php'); ?>
