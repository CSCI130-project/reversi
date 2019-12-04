<?php
# check if user is logged in
session_start();
if (!isset($_SESSION["username"]))
    header("location: index.html");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Reversi</title>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"> -->
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <style>
        .card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            margin-left: 10%;
            margin-right: 10%;
            margin-top: 10px;
            font-size: 30px;
            background-color: white;
            padding: 15px;
        }
        p {
            padding: 5px;
        }
    </style>
</head>

<body>
    <header role="banner">
        <nav id="navbar" role="navigation">
            <a class="brand"><strong>REVERSI</strong></a>
            <ul id="navigation">
                <li class="nav-items"><a class="nav-link" href="game.php">Play</a></li>
                <li class="nav-items"><a class="nav-link" href="leaderboard.php">Leaderboard</a></li>
                <li class="nav-items"><a class="nav-link active" href="rules.php">Rules</a></li>
                <li class="nav-items"><a class="nav-link" href="about.php">About</a></li>
                <li class="nav-items"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <section role="main" class="card">
        <h3 style="text-align: center">Reversi Rules</h3>
        <p>
            Reversi is a strategy board game for 2 players.
        </p>
        <p>
            Each player has disks that are either light or dark. Players take turns placing disks on the board with their assigned color facing up.
        </p>
        <p>The first 4 disks must be placed on the four center squares.</p>
        <p>
            During a play, any disks of the opponent's color that are in a straight or diagonal line and bounded by the disk just placed and another disk of the current player's color are turned over to the current player's color.
        </p>
        <p>
            Play against either another person or the computer. When starting a new game, select the grid size. When playing, you can change the disk colors and grid color.
        </p>
    </section>
</body>

</html>