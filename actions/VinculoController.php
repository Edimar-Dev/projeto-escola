<?php

$caminhoVinculos = __DIR__ . '/../data/turma_materias.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'vincular') {
    $turma_id = $_POST['turma_id'];
    $materia_ids = $_POST['materias'] ?? [];

    
    $vinculos = file_exists($caminhoVinculos)
        ? json_decode(file_get_contents($caminhoVinculos), true)
        : [];

    
    $vinculos = array_filter($vinculos, fn($v) => $v['turma_id'] !== $turma_id);

    
    foreach ($materia_ids as $materia_id) {
        $vinculos[] = [
            'turma_id' => $turma_id,
            'materia_id' => $materia_id
        ];
    }

    file_put_contents($caminhoVinculos, json_encode($vinculos, JSON_PRETTY_PRINT));

    header('Location: ../pages/vincular_materias.php?sucesso=ok');
    exit;
}