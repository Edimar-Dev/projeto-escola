<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alunoId = $_POST['aluno_id'] ?? null;

    if (!$alunoId) {
        header("Location: ../pages/alunos_por_turma.php?mensagem=" . urlencode("⚠ Parâmetro inválido."));
        exit;
    }

    $caminho = __DIR__ . '/../data/alunos.json';
    $alunos = file_exists($caminho) ? json_decode(file_get_contents($caminho), true) : [];

 
    foreach ($alunos as &$aluno) {
        if ($aluno['id'] === $alunoId) {
            $aluno['turma_id'] = '';
            break;
        }
    }

    file_put_contents($caminho, json_encode($alunos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    header("Location: ../pages/alunos_por_turma.php?mensagem=" . urlencode("✔ Aluno desvinculado com sucesso."));
    exit;
}

header("Location: ../pages/alunos_por_turma.php?mensagem=" . urlencode("⚠ Requisição inválida."));