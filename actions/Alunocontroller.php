<?php

$caminhoArquivo = __DIR__ . '/../data/alunos.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'cadastrar') {

    if (file_exists($caminhoArquivo)) {
        $conteudoArquivo = file_get_contents($caminhoArquivo);
        $alunos = json_decode($conteudoArquivo, true);
    } else {
        $alunos = [];
    }

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


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'excluir' && isset($_POST['id'])) {

    if (file_exists($caminhoArquivo)) {
        $conteudoArquivo = file_get_contents($caminhoArquivo);
        $alunos = json_decode($conteudoArquivo, true);

        $id = $_POST['id'];


        $alunos = array_filter($alunos, function($aluno) use ($id) {
            return $aluno['id'] !== $id;
        });


        $alunos = array_values($alunos);

        file_put_contents($caminhoArquivo, json_encode($alunos, JSON_PRETTY_PRINT));
    }

    header('Location: ../pages/alunos.php?excluido=ok');
    exit;
}

?>