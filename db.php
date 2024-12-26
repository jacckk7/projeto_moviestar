<?php

    $host = "localhost";
    $dbname = "moviestar";
    $user = "root";
    $pass = "";

    try {
        $conn = new PDO("mysql:host=$host", $user, $pass);

        // Cria banco de dados se ainda não existir
        $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
        $conn->exec($sql);

        // Conecta ao banco de dados
        $sql = "USE $dbname";
        $conn->exec($sql);
        
        // Ativar modo de erros
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        // Cria tabela users se ainda não existir
        $sql = "CREATE TABLE IF NOT EXISTS users(
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100),
            lastname VARCHAR(100),
            email VARCHAR(200),
            password VARCHAR(200),
            image VARCHAR(200),
            token VARCHAR(200),
            bio TEXT
        )";

        $conn->exec($sql);

        // Cria tabela movies se ainda não existir
        $sql = "CREATE TABLE IF NOT EXISTS movies(
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(100),
            description TEXT,
            image VARCHAR(200),
            trailer VARCHAR(150),
            category VARCHAR(50),
            length VARCHAR(50),
            users_id INT(11) UNSIGNED,
            FOREIGN KEY(users_id) REFERENCES users(id)
        )";

        $conn->exec($sql);

        // Cria tabela reviews se ainda não existir
        $sql = "CREATE TABLE IF NOT EXISTS reviews(
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            rating INT,
            review TEXT,
            users_id INT(11) UNSIGNED,
            movies_id INT(11) UNSIGNED,
            FOREIGN KEY(users_id) REFERENCES users(id),
            FOREIGN KEY(movies_id) REFERENCES movies(id)
        )";

        $conn->exec($sql);
    } catch(PDOException $e) {
        $error = $e->getMessage();
        echo "Erro: $error";
    }

?>