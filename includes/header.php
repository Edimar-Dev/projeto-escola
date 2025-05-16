<?php
$alunos = json_decode(file_get_contents(__DIR__ . '/../data/alunos.json'), true) ?? [];
$turmas = json_decode(file_get_contents(__DIR__ . '/../data/turmas.json'), true) ?? [];
$materias = json_decode(file_get_contents(__DIR__ . '/../data/materias.json'), true) ?? [];
$notas = json_decode(file_get_contents(__DIR__ . '/../data/notas.json'), true) ?? [];

$materiasIndexadas = [];
foreach ($materias as $m) {
    $materiasIndexadas[$m['id']] = $m['nome'];
}

$turmasIndexadas = [];
foreach ($turmas as $t) {
    $turmasIndexadas[$t['id']] = $t['nome'];
}

$resultadosPorMateriaETurma = [];

foreach ($notas as $nota) {
    $materiaId = $nota['materia_id'];
    $turmaId = $nota['turma_id'];
    $materiaNome = $materiasIndexadas[$materiaId] ?? 'Matéria desconhecida';
    $turmaNome = $turmasIndexadas[$turmaId] ?? 'Turma desconhecida';
    $media = array_sum($nota['notas']) / count($nota['notas']);

    if (!isset($resultadosPorMateriaETurma[$materiaNome])) {
        $resultadosPorMateriaETurma[$materiaNome] = [];
    }

    if (!isset($resultadosPorMateriaETurma[$materiaNome][$turmaNome])) {
        $resultadosPorMateriaETurma[$materiaNome][$turmaNome] = [
            'aprovados' => 0,
            'recuperacao' => 0,
            'reprovados' => 0
        ];
    }

    if ($media >= 6) {
        $resultadosPorMateriaETurma[$materiaNome][$turmaNome]['aprovados']++;
    } elseif ($media >= 4) {
        $resultadosPorMateriaETurma[$materiaNome][$turmaNome]['recuperacao']++;
    } else {
        $resultadosPorMateriaETurma[$materiaNome][$turmaNome]['reprovados']++;
    }
}
?>
<!DOCTYPE html>
<html lang="pr-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inícial</title>
</head>
<body>
    <header>
        <h1>Seja Bem-vindo!</h1>
        <nav>
            <a href="index.php">Página Inicial</a> |
            <a href="alunos.php">Alunos</a> |
            <a href="turmas.php">Turmas</a> |
            <a href="alunos_por_turma.php">Alunos por turmas</a> |
            <a href="materias.php">Matérias</a> |
            <a href="vincular_materias.php">Matérias Turmas</a> |
            <a href="notas.php">Notas</a> |
            <a href="resultados.php">Resultados</a> 
        </nav>
    </header>
    <hr>

<h2>Visão Geral</h2>

<ul>
    <li><strong>Total de alunos:</strong> <?= count($alunos) ?></li>
    <li><strong>Total de turmas:</strong> <?= count($turmas) ?></li>
    <li><strong>Total de matérias:</strong> <?= count($materias) ?></li>
    <li><strong>Total de lançamentos de notas:</strong> <?= count($notas) ?></li>
</ul>

<h3>Situação Geral dos Alunos por Matéria e Turma</h3>

<?php if (!empty($resultadosPorMateriaETurma)): ?>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Matéria</th>
                <th>Turma</th>
                <th style="color: green;">Aprovados</th>
                <th style="color: orange;">Recuperação</th>
                <th style="color: red;">Reprovados</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultadosPorMateriaETurma as $materiaNome => $turmas): ?>
                <?php foreach ($turmas as $turmaNome => $dados): ?>
                    <tr>
                        <td><?= htmlspecialchars($materiaNome) ?></td>
                        <td><?= htmlspecialchars($turmaNome) ?></td>
                        <td style="text-align: center;"><?= $dados['aprovados'] ?></td>
                        <td style="text-align: center;"><?= $dados['recuperacao'] ?></td>
                        <td style="text-align: center;"><?= $dados['reprovados'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Nenhuma nota lançada ainda.</p>
<?php endif; ?>

<p style="margin-top: 30px;">Utilize o menu acima para acessar as funcionalidades do sistema.</p>