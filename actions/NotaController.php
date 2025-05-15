<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$arquivo = __DIR__ . '/../data/notas.json';
$notas = file_exists($arquivo) ? json_decode(file_get_contents($arquivo), true) : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    if ($acao === 'cadastrar') {
        $aluno_id = $_POST['aluno_id'] ?? '';
        $materia_id = $_POST['materia_id'] ?? '';
        $turma_id = $_POST['turma_id'] ?? '';
        $notas_recebidas = $_POST['notas'] ?? [];

        if (empty($notas_recebidas) || !is_array($notas_recebidas)) {
            header('Location: ../pages/notas.php?erro=sem-notas');
            exit;
        }

        if (count($notas_recebidas) !== 4) {
            header('Location: ../pages/notas.php?erro=quantidade-notas');
            exit;
        }

        foreach ($notas_recebidas as $n) {
            if (!is_numeric($n) || $n < 0 || $n > 10) {
                header('Location: ../pages/notas.php?erro=nota-invalida');
                exit;
            }
        }

        $novaNota = [
            'id' => uniqid(),
            'aluno_id' => $aluno_id,
            'materia_id' => $materia_id,
            'turma_id' => $turma_id,
            'notas' => array_map('floatval', $notas_recebidas)
        ];

        $notas[] = $novaNota;
        file_put_contents($arquivo, json_encode($notas, JSON_PRETTY_PRINT));
        header('Location: ../pages/notas.php?sucesso=1');
        exit;

    } elseif ($acao === 'excluir') {
        $id = $_POST['id'] ?? '';
    
        $notas = array_filter($notas, function ($nota) use ($id) {
            return $nota['id'] !== $id;
        });
    
        file_put_contents($arquivo, json_encode(array_values($notas), JSON_PRETTY_PRINT));
        header('Location: ../pages/notas.php?excluido=1');
        exit;
    }
}
