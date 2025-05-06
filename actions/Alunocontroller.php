<?php

$caminhoArquivo = __DIR__ . '/../data/alunos.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['acao']) && $_POST['acao'] === 'cadastrar') {

        $nomeAluno = trim($_POST['aluno']);
        $turmaId = $_POST['turma_id'] ?? null;

        if (empty($nomeAluno) || empty($turmaId)) {
            header('Location: ../pages/alunos.php?erro=campos-obrigatorios');
            exit;
        }

        if (file_exists($caminhoArquivo)) {
            $alunos = json_decode(file_get_contents($caminhoArquivo), true);
        } else {
            $alunos = [];
        }

        foreach ($alunos as $aluno) {
            if (strtolower($aluno['nome']) === strtolower($nomeAluno) && $aluno['turma_id'] === $turmaId) {
                header('Location: ../pages/alunos.php?erro=ja-existe');
                exit;
            }
        }

        $novoAluno = [
            'id' => uniqid(),
            'nome' => $nomeAluno,
            'turma_id' => $turmaId,
        ];

        $alunos[] = $novoAluno;

        file_put_contents($caminhoArquivo, json_encode($alunos, JSON_PRETTY_PRINT));

        header('Location: ../pages/alunos.php?sucesso=ok');
        exit;
    }

    if (isset($_POST['acao']) && $_POST['acao'] === 'excluir' && isset($_POST['id'])) {
        if (file_exists($caminhoArquivo)) {
            $alunos = json_decode(file_get_contents($caminhoArquivo), true);

            $alunos = array_filter($alunos, function($aluno) {
                return $aluno['id'] !== $_POST['id'];
            });

            file_put_contents($caminhoArquivo, json_encode(array_values($alunos), JSON_PRETTY_PRINT));
        }

        header('Location: ../pages/alunos.php?excluido=ok');
        exit;
    }
}