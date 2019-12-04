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
            font-size: 30px;
        }

        section {
            text-align: center;
            margin-top: 50px;
        }

        div {
            display: inline-block;
            padding: 40px;
            margin: 5px;
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
                <li class="nav-items"><a class="nav-link" href="rules.php">Rules</a></li>
                <li class="nav-items"><a class="nav-link active" href="about.php">About</a></li>
                <li class="nav-items"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <section role="main">
        <div class="card" style="margin-right: 50px;">
            <img src="./img/william.jpg" alt="Oops" width="200px" height="250px">
            <p>
                William Chen
            </p>
            <p style="font-size: 20px"  >
                Bachelors in Computer Science - Fresno State
            </p>
        </div>
        <div class="card" style="margin-left: 50px;">
            <img src="./img/leo.png" alt="Oops" width="200px" height="250px">
            <p>
                Leonardo Yoshida
            </p>
            <p style="font-size: 20px">
                Bachelors in Computer Science - Fresno State
            </p>
        </div>

    </section>
</body>

</html>