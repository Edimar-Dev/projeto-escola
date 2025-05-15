<?php

$arquivoNotas = __DIR__ . '/../data/notas.json';

if (!file_exists($arquivoNotas)) {
    file_put_contents($arquivoNotas, json_encode([]));
}

$notas = json_decode(file_get_contents($arquivoNotas), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'];

    if ($acao === 'cadastrar') {

        if (isset($_POST['notas']) && is_array($_POST['notas'])) {
            $novaNota = [
                'id' => uniqid(),
                'aluno_id' => $_POST['aluno_id'],
                'materia_id' => $_POST['materia_id'],
                'turma_id' => $_POST['turma_id'],
                'notas' => array_map('floatval', $_POST['notas'])
            ];

            $notas[] = $novaNota;
            file_put_contents($arquivoNotas, json_encode($notas, JSON_PRETTY_PRINT));
            header('Location: ../pages/notas.php?sucesso=1');
            exit;
        } else {
            header('Location: ../pages/notas.php?erro=sem-notas');
            exit;
        }
    }
}