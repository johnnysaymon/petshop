<?php

return [
    PDO::class => function(): PDO
    {
        $pdo = new PDO(
            "mysql:dbname=app;"
                . "host=db;"
                . "port=3306;"
                . "charset=utf8",
            'root',
            'root'
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    },
];