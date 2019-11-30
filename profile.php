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
        <header>
            <nav id="navbar">
                <a class="brand"><strong>REVERSI</strong></a>
                <ul id="navigation">
                    <li class="nav-items"><a class="nav-link" href="game.php">Play</a></li>
                    <li class="nav-items"><a class="nav-link active" href="profile.php">Profile</a></li>
                </ul>
            </nav>
        </header>

        <form>
            <select name="gridSize">
                <option value="4" selected>4x4</option>
                <option value="6x6"></option>
                <option value="8">8x8</option>
            </select>
            <select name="orderBy">
                <option value="score" selected>Score</option>
                <option value="time">Time Played</option>
                <option value="score_reverse" selected>Score - Reverse</option>
                <option value="time_reverse">Time Played - Reverse</option>
            </select>
        </form>
        <button onclick="getLeaderboard()">Get Leaderboard</button>
        <div id="leaderboard"></div>
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