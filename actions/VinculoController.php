<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['acao'] === 'vincular') {
    $turmaId = $_POST['turma_id'] ?? null;
    $materiasSelecionadas = $_POST['materias'] ?? [];

    if (!$turmaId || empty($materiasSelecionadas)) {
        header("Location: ../pages/vincular_materias.php?erro=campos");
        exit;
    }

    $caminho = __DIR__ . '/../data/turma_materias.json';


    $vinculos = file_exists($caminho) ? json_decode(file_get_contents($caminho), true) : [];


    foreach ($materiasSelecionadas as $materiaId) {
        $existe = false;
        foreach ($vinculos as $v) {
            if ($v['turma_id'] == $turmaId && $v['materia_id'] == $materiaId) {
                $existe = true;
                break;
            }
        }

        if (!$existe) {
            $vinculos[] = [
                'turma_id' => $turmaId,
                'materia_id' => $materiaId
            ];
        }
    }


    file_put_contents($caminho, json_encode($vinculos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    header("Location: ../pages/vincular_materias.php?sucesso=1");
    exit;
}