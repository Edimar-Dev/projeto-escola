<?php require_once('./index.php'); ?>

<div>
    <h3>RELAÇÃO DE MATÉRIAS</h3>
    <form action="../controllers/materiasController.php" method="POST">
        <input type="hidden" name="acao" value="cadastrar">
        <label for="materia">Nome da Matéria:</label>
        <input type="text" name="materia" id="materia" required>
        <button type="submit">Cadastrar</button>
</div>

<?php require_once('../includes/footer.php')?>