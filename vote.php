<?php

include 'functions.php';

$pdo = pdoConnectMysql();

// Verifica se a solicitação GET existe
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se o registro da enquete existe com o id especificado
    if ($poll) {
        $stmt = $pdo->prepare('SELECT * FROM poll_answers WHERE poll_id = ?');
        $stmt->execute([$_GET['id']]);

        $poll_answers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Verifica se o usuário clicou no botão votar
        if (isset($_POST['poll_answer'])) {
            $stmt = $pdo->prepare('UPDATE poll_answers SET votes = votes + 1 WHERE id = ?');
            $stmt->execute([$_POST['poll_answer']]);

            // Redireciona o usuario para a pagina de resultado
            header('Location: result.php?id=' . $_GET['id']);
            exit;
        }
    } else {
        exit('OPS! A enquete com esse ID não existe.');
    }
} else {
    exit('Nenhum ID de pesquisa especificado.');
}

?>

<?= templateHeader('Votação Enquete') ?>

<div class="content poll-vote">

    <h2><?= $poll['title'] ?></h2>
    <p><?= $poll['description'] ?></p>
    <form action="vote.php?id=<?= $_GET['id'] ?>" method="post">
        <?php for ($i = 0; $i < count($poll_answers); $i++) : ?>
            <label>
                <input type="radio" name="poll_answer" value="<?= $poll_answers[$i]['id'] ?>" <?= $i == 0 ? ' checked' : '' ?>>
                <?= $poll_answers[$i]['answers'] ?>
            </label>
        <?php endfor; ?>
        <div>
            <input type="submit" value="Vote">
            <a href="result.php?id=<?= $poll['id'] ?>">Ver Resultado</a>
        </div>
    </form>
</div>

<?= templateFooter() ?>