<?php 

$caminhoArquivo = __DIR__ . '/../data/turmas.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['acao'])) {
        if ($_POST['acao'] === 'cadastrar') {

            if (file_exists($caminhoArquivo)) {
                $conteudo = file_get_contents($caminhoArquivo);
                $turmas = json_decode($conteudo, true);
            } else {
                $turmas = [];
            }

            $nomeTurma = trim($_POST['turma']);

            foreach ($turmas as $turma) {
                if (strtolower($turma['nome']) === strtolower($nomeTurma)) {
                    header('Location: ../pages/turmas.php?erro=ja-existe');
                    exit;
                }
            }

            $novaTurma = [
                'id' => uniqid(),
                'nome' => $nomeTurma,
            ];

            $turmas[] = $novaTurma;
            file_put_contents($caminhoArquivo, json_encode($turmas, JSON_PRETTY_PRINT));

            header('Location: ../pages/turmas.php?sucesso=ok');
            exit;

        } elseif ($_POST['acao'] === 'excluir') {

            if (file_exists($caminhoArquivo)) {
                $conteudo = file_get_contents($caminhoArquivo);
                $turmas = json_decode($conteudo, true);

                $idExcluir = $_POST['id'];


                $turmas = array_filter($turmas, function($turma) use ($idExcluir) {
                    return $turma['id'] !== $idExcluir;
                });

                file_put_contents($caminhoArquivo, json_encode(array_values($turmas), JSON_PRETTY_PRINT));

                header('Location: ../pages/turmas.php?sucesso=excluido');
                exit;
            }
        }
    }
}
?>