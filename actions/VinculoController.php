<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['acao'] === 'vincular') {
    $turmaId = $_POST['turma_id'] ?? null;
    $materiasSelecionadas = $_POST['materias'] ?? [];

    if (!$turmaId || empty($materiasSelecionadas)) {
        header("Location: ../pages/vincular_materias.php?erro=campos");
        exit;
    }

    $caminho = __DIR__ . '/../data/turma_materias.json';
    $caminhoMaterias = __DIR__ . '/../data/materias.json';


    $vinculos = file_exists($caminho) ? json_decode(file_get_contents($caminho), true) : [];


    $materias = file_exists($caminhoMaterias) ? json_decode(file_get_contents($caminhoMaterias), true) : [];
    $nomesMaterias = [];
    foreach ($materias as $m) {
        $nomesMaterias[$m['id']] = $m['nome'];
    }

    $mensagens = [];

    foreach ($materiasSelecionadas as $materiaId) {
        $existe = false;

        foreach ($vinculos as $v) {
            if ($v['turma_id'] === $turmaId && $v['materia_id'] === $materiaId) {
                $existe = true;
                break;
            }
        }

        if ($existe) {
            $mensagens[] = "⚠ A matéria <strong>{$nomesMaterias[$materiaId]}</strong> já está vinculada à turma.";
        } else {
            $vinculos[] = [
                'turma_id' => $turmaId,
                'materia_id' => $materiaId
            ];
            $mensagens[] = "✔ A matéria <strong>{$nomesMaterias[$materiaId]}</strong> foi vinculada com sucesso.";
        }
    }


    file_put_contents($caminho, json_encode($vinculos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));


    $mensagemFinal = urlencode(implode("<br>", $mensagens));
    header("Location: ../pages/vincular_materias.php?mensagem={$mensagemFinal}");
    exit;
}