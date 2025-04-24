<?php 

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'cadastrar') {

    $caminhoArquivo = __DIR__ .'../data/materias.json';

    if(file_exists($caminhoArquivo)){
        $conteudoArquivo = file_get_contents($caminhoArquivo);
        $materias = json_decode($conteudoArquivo, true);
    } else {
        $materias = array();
    }

    
    $novaMateria = [
        'id' =>uniqid(),
        'nome'=> $_POST['materia'],
    ];

    $materias[] = $novaMateria;
    file_put_contents($caminhoArquivo, json_encode($materias, JSON_PRETTY_PRINT));
    header('Location: ../pages/materias.php');

}





?>