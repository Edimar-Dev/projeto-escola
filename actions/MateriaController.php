<?php 


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'cadastrar') {
    
    $caminhoArquivo = __DIR__ . '/../data/materias.json';

    
    if (file_exists($caminhoArquivo)) {
        $conteudoArquivo = file_get_contents($caminhoArquivo);
        $materias = json_decode($conteudoArquivo, true);
    } else {
        $materias = [];
    }

    $nomeMateria = trim($_POST['materia']);

    
    foreach ($materias as $materia) {
        if (strtolower($materia['nome']) === strtolower($nomeMateria)) {
            
            header('Location: ../pages/materias.php?erro=ja-existe');
            exit;
        }
    }

    $novaMateria = [
        'id' => uniqid(),
        'nome' => $nomeMateria,
    ];

    $materias[] = $novaMateria;

    
    file_put_contents($caminhoArquivo, json_encode($materias, JSON_PRETTY_PRINT));

    header('Location: ../pages/materias.php?sucesso=ok');
    exit;
}

//Excluir matéria

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'excluir') {
    $caminhoArquivo = __DIR__ . '/../data/materias.json';

    if (file_exists($caminhoArquivo)) {
        $conteudo = file_get_contents($caminhoArquivo);
        $materias = json_decode($conteudo, true);

        $materias = array_filter($materias, function ($materia) {
            return $materia['id'] !== $_POST['id'];
        });

        $materias = array_values($materias); 
        file_put_contents($caminhoArquivo, json_encode($materias, JSON_PRETTY_PRINT));
    }

    header('Location: ../pages/materias.php?sucesso=excluida');
    exit;
}

?>