<?php require_once('./index.php'); ?>

<h3>CADASTRAR NOTAS</h3>

<?php
$alunos = json_decode(file_get_contents(__DIR__ . '/../data/alunos.json'), true) ?? [];
$materias = json_decode(file_get_contents(__DIR__ . '/../data/materias.json'), true) ?? [];
$turmas = json_decode(file_get_contents(__DIR__ . '/../data/turmas.json'), true) ?? [];
?>


<?php if (isset($_GET['erro'])): ?>
    <?php if ($_GET['erro'] === 'sem-notas'): ?>
        <p style="color: red;">Erro: As notas não foram informadas corretamente.</p>
    <?php elseif ($_GET['erro'] === 'quantidade-notas'): ?>
        <p style="color: red;">Erro: Devem ser informadas exatamente 4 notas.</p>
    <?php elseif ($_GET['erro'] === 'nota-invalida'): ?>
        <p style="color: red;">Erro: Cada nota deve estar entre 0 e 10.</p>
    <?php else: ?>
        <p style="color: red;">Erro desconhecido.</p>
    <?php endif; ?>
<?php elseif (isset($_GET['sucesso'])): ?>
    <p style="color: green;">Nota cadastrada com sucesso!</p>
<?php endif; ?>

<form action="../actions/NotaController.php" method="POST">
    <input type="hidden" name="acao" value="cadastrar">

    <label>Aluno:</label>
    <select name="aluno_id" id="aluno_id" required>
        <option value="">Selecione</option>
        <?php foreach ($alunos as $aluno): ?>
            <option value="<?= $aluno['id'] ?>" data-turma="<?= $aluno['turma_id'] ?>">
                <?= htmlspecialchars($aluno['nome']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Turma:</label>
    <input type="text" id="turma_exibida" readonly>
    <input type="hidden" name="turma_id" id="turma_id">

    <label>Matéria:</label>
    <select name="materia_id" required>
        <option value="">Selecione</option>
        <?php foreach ($materias as $materia): ?>
            <option value="<?= $materia['id'] ?>"><?= htmlspecialchars($materia['nome']) ?></option>
        <?php endforeach; ?>
    </select>

    <br><br>

    <label>Nota 1:</label>
    <input type="number" name="notas[]" min="0" max="10" step="0.1" required>

    <label>Nota 2:</label>
    <input type="number" name="notas[]" min="0" max="10" step="0.1" required>

    <label>Nota 3:</label>
    <input type="number" name="notas[]" min="0" max="10" step="0.1" required>

    <label>Nota 4:</label>
    <input type="number" name="notas[]" min="0" max="10" step="0.1" required>

    <br><br>
    <button type="submit">Cadastrar Notas</button>
</form>

<hr>

<h3>NOTAS CADASTRADAS</h3>

<?php
$arquivoNotas = __DIR__ . '/../data/notas.json';
$notas = file_exists($arquivoNotas) ? json_decode(file_get_contents($arquivoNotas), true) : [];

if (!empty($notas)):
?>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Aluno</th>
                <th>Matéria</th>
                <th>Turma</th>
                <th>Nota 1</th>
                <th>Nota 2</th>
                <th>Nota 3</th>
                <th>Nota 4</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($notas as $nota): 
                $alunoNome = '';
                $materiaNome = '';
                $turmaNome = '';

                foreach ($alunos as $a) {
                    if ($a['id'] === $nota['aluno_id']) {
                        $alunoNome = $a['nome'];
                        break;
                    }
                }

                foreach ($materias as $m) {
                    if ($m['id'] === $nota['materia_id']) {
                        $materiaNome = $m['nome'];
                        break;
                    }
                }

                foreach ($turmas as $t) {
                    if ($t['id'] === $nota['turma_id']) {
                        $turmaNome = $t['nome'];
                        break;
                    }
                }
            ?>
                <tr>
                    <td><?= htmlspecialchars($alunoNome) ?></td>
                    <td><?= htmlspecialchars($materiaNome) ?></td>
                    <td><?= htmlspecialchars($turmaNome) ?></td>
                    <?php for ($i = 0; $i < 4; $i++): ?>
                        <td><?= $nota['notas'][$i] ?? '-' ?></td>
                    <?php endfor; ?>
                    <td>
                        <form action="../actions/NotaController.php" method="POST" onsubmit="return confirm('Deseja realmente excluir esta nota?');">
                            <input type="hidden" name="acao" value="excluir">
                            <input type="hidden" name="id" value="<?= $nota['id'] ?>">
                            <button type="submit">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Nenhuma nota cadastrada ainda.</p>
<?php endif ?>

<?php
$turmaNomes = [];
foreach ($turmas as $turma) {
    $turmaNomes[$turma['id']] = $turma['nome'];
}
?>

<script>
    const turmaNomes = <?= json_encode($turmaNomes) ?>;

    document.getElementById('aluno_id').addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        const turmaId = selected.getAttribute('data-turma');
        const turmaNome = turmaNomes[turmaId] || 'Turma não encontrada';

        document.getElementById('turma_id').value = turmaId;
        document.getElementById('turma_exibida').value = turmaNome;
    });
</script>

<?php require_once('../includes/footer.php'); ?>