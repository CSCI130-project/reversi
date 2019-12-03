<?php
    # check if user is logged in
    session_start();
    if(!isset($_SESSION["username"]))
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
    </head>
    <body>
        <header role="banner">
            <nav id="navbar" role="navigation">
                <a class="brand"><strong>REVERSI</strong></a>
                <ul id="navigation">
                    <li class="nav-items"><a class="nav-link" href="game.php">Play</a></li>
                    <li class="nav-items"><a class="nav-link active" href="leaderboard.php">Leaderboard</a></li>
                    <li class="nav-items"><a class="nav-link" href="rules.php">Rules</a></li>
                    <li class="nav-items"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-items"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </header>
        <div id="leaderboardPage" role="main">
            <div id="leaderboardSelect">
            <form id="leaderboardForm">
                <label>Grid Size:</label>
                <select name="gridSize">
                    <option value="4" selected>4x4</option>
                    <option value="6">6x6</option>
                    <option value="8">8x8</option>
                </select>
                <br>
                <label>Order By:</label>
                <select name="orderBy" id="orderBy">
                    <option value="score" selected>Score</option>
                    <option value="time">Time Played</option>
                    <option value="score_reverse">Score - Reverse</option>
                    <option value="time_reverse">Time Played - Reverse</option>
                </select>
            </form>
            <button id="b" onclick="getLeaderboard()">Get Leaderboard</button>
        </div>
            <div id="leaderboard"></div>
        </div>
    <script>
        function getLeaderboard()
        {
            var formElement = document.querySelector("form");
            var formData = new FormData(formElement);
            $.ajax({
                url: 'orderLeaderboard.php',
                data: formData,
                type: 'POST',
                contentType: false,
                processData: false,
                success: function(data)
                {
                    document.getElementById("leaderboard").innerHTML = data;
                    //$(img).addClass('leaderboardImage'); 
                }
            });
        }
    </script>
    </body>
</html>