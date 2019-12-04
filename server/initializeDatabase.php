<?php
    # Initialize MySQL database
    # Create Players and Games tables

    include "database.php";

    function createReversiDatabase()
    {
        global $server, $usernameSQL, $passwordSQL, $database;
        $conn = new mysqli($server, $usernameSQL, $passwordSQL);
        $query = "CREATE DATABASE " . $database;
        if($conn->query($query))
            echo "Database created: $database<br>";
        else
            echo "Database creation error: $conn->error<br>";
        $conn->close();
    }
    function createPlayersTable()
    {
        global $server, $usernameSQL, $passwordSQL, $database;
        $conn = new mysqli($server, $usernameSQL, $passwordSQL, $database);
        $query = "CREATE TABLE Players(
            username VARCHAR(30) NOT NULL PRIMARY KEY,
            password VARCHAR(256) NOT NULL,
            firstname VARCHAR(30) NOT NULL,
            lastname VARCHAR(30) NOT NULL,
            age INT(3) UNSIGNED NOT NULL,
            gender VARCHAR(6) NOT NULL,
            location VARCHAR(30) NOT NULL,
            photo VARCHAR(256) NOT NULL
        )";
        if($conn->query($query))
            echo "Table created: Players<br>";
        else
            echo "Table Players creation error: $conn->error<br>";
        $conn->close();
    }
    function createGamesTable()
    {
        global $server, $usernameSQL, $passwordSQL, $database;
        $conn = new mysqli($server, $usernameSQL, $passwordSQL, $database);
        $query = "CREATE TABLE Games(
            gameID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            gridSize INT(1) UNSIGNED NOT NULL,
            username VARCHAR(30) NOT NULL,
            score INT(4) UNSIGNED NOT NULL,
            timePlayed VARCHAR(30) NOT NULL,
            isWon VARCHAR(5) NOT NULL 
        )";
        if($conn->query($query))
            echo "Table created: Games<br>";
        else
            echo "Table Games creation error: $conn->error<br>";
        $conn->close();
    }
    createReversiDatabase();
    createPlayersTable();
    createGamesTable();
?>