<?php

include 'functions.php';

$pdo = pdoConnectMysql();

// Verifica se a solicitação GET existe
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se o registro da pesquisa existe com o id especificado
    if ($poll) {

        // Obtem todas as respostas da tabela "poll_answers" ordenadas pelo número de votos (decrescente)
        $stmt = $pdo->prepare('SELECT * FROM poll_answers WHERE poll_id = ? ORDER BY votes DESC');
        $stmt->execute([$_GET['id']]);
        $poll_answers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Número total de votos, será usado para calcular a porcentagem
        $total_votes = 0;
        foreach ($poll_answers as $poll_answer) {

            // Todos os votos de respostas da enquete serão adicionados ao total de votos
            $total_votes += $poll_answer['votes'];
        }
    } else {
        exit('OPS! A enquete com esse ID não existe.');
    }
} else {
    exit('Nenhum ID de pesquisa especificado.');
}

?>

<?= templateHeader('Resultados da Enquete') ?>

<div class="content poll-result">
    <h2><?= $poll['title'] ?></h2>
    <p><?= $poll['description'] ?></p>
    <div class="wrapper">
        <?php foreach ($poll_answers as $poll_answer) : ?>
            <div class="poll-question">
                <p><?= $poll_answer['answers'] ?> <span>(<?= $poll_answer['votes'] ?> votos)</span></p>
                <div class="result-bar" style="width:<?= @round(($poll_answer['votos'] / $total_votes) * 100) ?>%">
                    <?= @round(($poll_answer['votes'] / $total_votes) * 100) ?>%
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?= templateFooter() ?>