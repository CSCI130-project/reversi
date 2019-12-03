<?php
    include "database.php";

    session_start();

    $gridSize = intval($_POST["gridSize"]);
    $username = $_SESSION["username"];
    $score = intval($_POST["score"]);
    $timePlayed = $_POST["timePlayed"];
    $isWon = $_POST["isWon"];

    $conn = new mysqli($server, $usernameSQL, $passwordSQL, $database);
    if($conn->error)
        die($conn->error);
    
    $sql = "INSERT INTO Games(gridSize, username, score, timePlayed, isWon) VALUES($gridSize, '$username', $score, '$timePlayed', '$isWon')";
    $conn->query($sql);
    if($conn->error)
        die($conn->error);

    echo json_encode(["username" => $username]);
?>