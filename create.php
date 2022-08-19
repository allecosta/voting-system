<?php

include 'functions.php';

$pdo = pdoConnectMysql();

$msg = "";


// Verifixa se a postagem dos dados estão vazio
if (!empty($_POST)) {
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';

    $stmt = $pdo->prepare('INSERT INTO polls (title, description) VALUES (?, ?)');
    $stmt->execute([$title, $description]);

    $poll_id = $pdo->lastInsertId();

    $answers = isset($_POST['answers']) ? explode(PHP_EOL, $_POST['answers']) : '';
    foreach ($answers as $answer) {
        if (empty($answer)) continue;

        $stmt = $pdo->prepare('INSERT INTO poll_answers (poll_id, answers) VALUES (?, ?)');
        $stmt->execute([$poll_id, $answer]);
    }

    $msg = '<p style="color: green;">Criado com sucesso!</p>';
}

?>

<?= templateHeader('Criar Enquete') ?>

<div class="content update">
    <h2>Criar Enquete</h2>
    <form action="create.php" method="post">
        <label for="title">Título</label>
        <input type="text" name="title" id="title" placeholder="Faça aqui a sua pergunta" required>
        <label for="description">Descrição</label>
        <input type="text" name="description" id="description" placeholder="Faça uma breve descrição (opcional)">
        <label for="answers">Respostas</label>
        <textarea name="answers" id="answers" placeholder="Uma opção por linha (no maximo 3)" required></textarea>

        <?php /*if ($_POST['answers'] > 3) : ?>
            <p><?= echo "Não é permitido mais que 3 opções de repostas"; break; ?></p>
        <?php endif;*/ ?>
        <input type="submit" value="Enviar">
    </form>

    <?php
    if ($msg) : ?>
        <p> <?= $msg ?> </p>
    <?php endif; ?>
</div>

<?= templateFooter() ?>