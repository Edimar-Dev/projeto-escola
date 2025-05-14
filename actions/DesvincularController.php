<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $turmaId = $_POST['turma_id'] ?? null;
    $materiaId = $_POST['materia_id'] ?? null;

    if (!$turmaId || !$materiaId) {
        header("Location: ../pages/vincular_materias.php?mensagem=" . urlencode("⚠ Parâmetros inválidos."));
        exit;
    }

    $caminho = __DIR__ . '/../data/turma_materias.json';
    $vinculos = file_exists($caminho) ? json_decode(file_get_contents($caminho), true) : [];


    $vinculosAtualizados = array_filter($vinculos, function ($v) use ($turmaId, $materiaId) {
        return !($v['turma_id'] === $turmaId && $v['materia_id'] === $materiaId);
    });

    file_put_contents($caminho, json_encode(array_values($vinculosAtualizados), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    header("Location: ../pages/vincular_materias.php?mensagem=" . urlencode("✔ Matéria desvinculada com sucesso."));
    exit;
}

header("Location: ../pages/vincular_materias.php?mensagem=" . urlencode("⚠ Requisição inválida."));