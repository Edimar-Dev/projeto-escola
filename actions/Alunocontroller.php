<?php

$caminhoArquivo = __DIR__ . '/../data/alunos.json';


$alunos = file_exists($caminhoArquivo)
    ? json_decode(file_get_contents($caminhoArquivo), true)
    : [];


if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['acao'] === 'cadastrar') {
    $nomeAluno = trim($_POST['aluno']);


    foreach ($alunos as $aluno) {
        if (strtolower($aluno['nome']) === strtolower($nomeAluno)) {
            header('Location: ../pages/alunos.php?erro=ja-existe');
            exit;
        }
    }

    $novoAluno = [
        'id' => uniqid(),
        'nome' => $nomeAluno,
    ];

    $alunos[] = $novoAluno;

    file_put_contents($caminhoArquivo, json_encode($alunos, JSON_PRETTY_PRINT));

    header('Location: ../pages/alunos.php?sucesso=ok');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['acao'] === 'excluir' && isset($_POST['id'])) {
    $id = $_POST['id'];

    $alunos = array_filter($alunos, fn($aluno) => $aluno['id'] !== $id);
    $alunos = array_values($alunos); // reorganiza os índices

    file_put_contents($caminhoArquivo, json_encode($alunos, JSON_PRETTY_PRINT));

    header('Location: ../pages/alunos.php?excluido=ok');
    exit;
}


header('Location: ../pages/alunos.php');
exit;