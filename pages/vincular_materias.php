<?php require_once('./index.php'); ?>

<h3>Vincular Matérias a Turmas</h3>

<form action="../actions/VinculoController.php" method="POST">
    <input type="hidden" name="acao" value="vincular">

    <label for="turma">Selecione a Turma:</label>
    <select name="turma_id" id="turma" required>
        <option value="">Selecione</option>
        <?php
        $turmas = json_decode(file_get_contents(__DIR__ . '/../data/turmas.json'), true);
        foreach ($turmas as $turma) {
            echo "<option value=\"{$turma['id']}\">" . htmlspecialchars($turma['nome']) . "</option>";
        }
        ?>
    </select>

    <br><br>

    <label>Selecione as Matérias:</label><br>
    <?php
    $materias = json_decode(file_get_contents(__DIR__ . '/../data/materias.json'), true);
    foreach ($materias as $materia) {
        echo "<input type='checkbox' name='materias[]' value=\"{$materia['id']}\"> " . htmlspecialchars($materia['nome']) . "<br>";
    }
    ?>

    <br>
    <button type="submit">Vincular</button>

    <?php if (isset($_GET['sucesso'])): ?>
        <p style="color: green;">Matérias vinculadas com sucesso!</p>
    <?php endif; ?>
</form>

<hr>

<div>
    <h3>Matérias vinculadas às turmas</h3>

    <?php
    $caminhoVinculos = __DIR__ . '/../data/turma_materias.json';
    $caminhoMaterias = __DIR__ . '/../data/materias.json';
    $caminhoTurmas   = __DIR__ . '/../data/turmas.json';

    $vinculos = file_exists($caminhoVinculos) ? json_decode(file_get_contents($caminhoVinculos), true) : [];
    $materias = file_exists($caminhoMaterias) ? json_decode(file_get_contents($caminhoMaterias), true) : [];
    $turmas   = file_exists($caminhoTurmas)   ? json_decode(file_get_contents($caminhoTurmas), true) : [];

    
    $mapMaterias = [];
    foreach ($materias as $materia) {
        $mapMaterias[$materia['id']] = $materia['nome'];
    }

    $mapTurmas = [];
    foreach ($turmas as $turma) {
        $mapTurmas[$turma['id']] = $turma['nome'];
    }

    if (!empty($vinculos)) {
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>Matéria</th><th>Turma</th></tr>";
        foreach ($vinculos as $vinculo) {
            $materiaNome = $mapMaterias[$vinculo['materia_id']] ?? 'Matéria não encontrada';
            $turmaNome   = $mapTurmas[$vinculo['turma_id']] ?? 'Turma não encontrada';

            echo "<tr><td>$materiaNome</td><td>$turmaNome</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Nenhuma matéria vinculada ainda.</p>";
    }
    ?>
</div>


<?php require_once('../includes/footer.php'); ?>