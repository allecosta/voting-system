<?php

include 'functions.php';

$pdo = pdoConnectMysql();

// Query que recupera todas as enquetes e respostas da pesquisa
$stmt = $pdo->query('SELECT p.*, GROUP_CONCAT(pa.answers ORDER BY pa.id) AS answers FROM polls p 
    LEFT JOIN poll_answers pa ON pa.poll_id = p.id GROUP BY p.id');
$polls = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?= templateHeader('Enquetes') ?>

<div class="content home">
    <h2>Enquetes</h2>
    <p>Bem-vindo à página inicial! Você pode visualizar a lista de pesquisas abaixo:</p>
    <a href="create.php" class="create-poll">Criar Enquete</a>
    <table>
        <thead>
            <tr>
                <td>#</td>
                <td>Titulo</td>
                <td>Respostas</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($polls as $poll) : ?>
                <tr>
                    <td><?= $poll['id'] ?></td>
                    <td><?= $poll['title'] ?></td>
                    <td><?= $poll['answers'] ?></td>
                    <td class="actions">
                        <a href="vote.php?id=<?= $poll['id'] ?>" class="view" title="Ver enquete"><i class="fas fa-eye fa-xs"></i></a>
                        <a href="delete.php?id=<?= $poll['id'] ?>" class="trash" title="Deletar enquete"><i class="fas fa-trash fa-xs"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= templateFooter() ?>