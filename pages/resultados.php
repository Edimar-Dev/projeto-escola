<?php require_once('./index.php'); ?>

<h3>RESULTADOS DOS ALUNOS</h3>

<?php
$notas = json_decode(file_get_contents(__DIR__ . '/../data/notas.json'), true) ?? [];
$alunos = json_decode(file_get_contents(__DIR__ . '/../data/alunos.json'), true) ?? [];
$materias = json_decode(file_get_contents(__DIR__ . '/../data/materias.json'), true) ?? [];
$turmas = json_decode(file_get_contents(__DIR__ . '/../data/turmas.json'), true) ?? [];


function buscarNomePorId($array, $id) {
    foreach ($array as $item) {
        if ($item['id'] === $id) return $item['nome'];
    }
    return 'Desconhecido';
}


$notasPorTurma = [];
foreach ($notas as $nota) {
    $turmaId = $nota['turma_id'];
    if (!isset($notasPorTurma[$turmaId])) {
        $notasPorTurma[$turmaId] = [];
    }
    $notasPorTurma[$turmaId][] = $nota;
}

if (empty($notasPorTurma)) {
    echo "<p>Nenhuma nota cadastrada.</p>";
} else {
    foreach ($notasPorTurma as $turmaId => $notasTurma):
        $nomeTurma = buscarNomePorId($turmas, $turmaId);
        echo "<h4>Turma: " . htmlspecialchars($nomeTurma) . "</h4>";
?>
        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>Aluno</th>
                <th>Matéria</th>
                <th>Notas</th>
                <th>Média</th>
                <th>Situação</th>
            </tr>
            <?php foreach ($notasTurma as $nota):
                $nomeAluno = buscarNomePorId($alunos, $nota['aluno_id']);
                $nomeMateria = buscarNomePorId($materias, $nota['materia_id']);
                $notasAluno = $nota['notas'];
                $media = array_sum($notasAluno) / count($notasAluno);
                $media = round($media, 2);
                
                if ($media >= 6) {
                    $situacao = "<span style='color: green;'>Aprovado</span>";
                } elseif ($media >= 4) {
                    $situacao = "<span style='color: orange;'>Recuperação</span>";
                } else {
                    $situacao = "<span style='color: red;'>Reprovado</span>";
                }
            ?>
                <tr>
                    <td><?= htmlspecialchars($nomeAluno) ?></td>
                    <td><?= htmlspecialchars($nomeMateria) ?></td>
                    <td><?= implode(', ', $notasAluno) ?></td>
                    <td><?= $media ?></td>
                    <td><?= $situacao ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br>
<?php
    endforeach;
}
?>

<?php require_once('../includes/footer.php'); ?>