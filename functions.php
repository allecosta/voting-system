<?php

function pdoConnectMysql()
{
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = '* * *';
    $DATABASE_PASS = '* * *';
    $DATABASE_NAME = '* * *';

    try {
        return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
        // Se houver um erro na conexão, pare o script e exiba o erro
        exit('Failed to connect to database!');
    }
}

function templateHeader($title)
{
    echo <<<EOT
        <!DOCTYPE html>
        <html>
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <title>$title</title>
                <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
                <link href="/assets/css/style.css" rel="stylesheet" type="text/css">     
            </head>
            <body>
                <header>
                    <nav class="navtop">
                        <div>
                            <h1>Signo Sistemas Web</h1>
                            <a href="index.php"><i class="fas fa-poll-h"></i>Enquetes</a>
                        </div>
                    </nav>
                </header>
    EOT;
}

function templateFooter()
{
    echo <<<EOT
            </body>
        </html>
    EOT;
}
