<?php

include 'functions.php';

$pdo = pdoConnectMysql();

$msg = "";

// Verifica se o ID da enquete existe
if (isset($_GET['id'])) {

    // Seleciona o registro que será excluído
    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$poll) {
        exit('Não existe enquete com esse ID!');
    }
    // Certifica-se que o usuário confirme antes da exclusão
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {

            // Executando a exclusao da enquete
            $stmt = $pdo->prepare('DELETE FROM polls WHERE id = ?');
            $stmt->execute([$_GET['id']]);

            // Executando a exclusao das respostas
            $stmt = $pdo->prepare('DELETE FROM poll_answers WHERE poll_id = ?');
            $stmt->execute([$_GET['id']]);

            $msg = 'Você excluiu a enquete!';
        } else {
            // Redireciona de volta para a página inicial
            header('Location: index.php');
            exit;
        }
    }
} else {
    exit('Nenhum ID especificado!');
}

?>

<?= templateHeader('Delete') ?>

<div class="content delete">
    <h2>Enquete #<?= $poll['id'] ?></h2>
    <?php if ($msg) : ?>
        <p><?= $msg ?></p>
    <?php else : ?>
        <p>Tem certeza de que deseja excluir a enquete #<?= $poll['id'] ?>?</p>
        <div class="yesno">
            <a href="delete.php?id=<?= $poll['id'] ?>&confirm=yes">Sim</a>
            <a href="delete.php?id=<?= $poll['id'] ?>&confirm=no">Não</a>
        </div>
    <?php endif; ?>
</div>

<?= templateFooter() ?>