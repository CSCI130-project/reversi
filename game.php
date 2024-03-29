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
</head>

<header role="banner">
    <nav id="navbar" role="navigation">
        <a class="brand"><strong>REVERSI</strong></a>
        <ul id="navigation">
            <li class="nav-items"><a class="nav-link active" href="game.php">Play</a></li>
            <li class="nav-items"><a class="nav-link" href="leaderboard.php">Leaderboard</a></li>
            <li class="nav-items"><a class="nav-link" href="rules.php">Rules</a></li>
            <li class="nav-items"><a class="nav-link" href="about.php">About</a></li>
            <li class="nav-items"><a class="nav-link" href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

<body>
    <form id="configForm">
        <div>
            <label><strong>Play Against:</strong></label>
            <div>
                <input id="opponentPlayer" type="radio" name="opponentType" value="Person" checked>Person <br />
                <input id="opponentComputer" type="radio" name="opponentType" value="Computer">Computer <br />
            </div>
        </div>
        <br />
        <div>
            <label for="layoutSize"><strong>Select Grid Size:</strong></label>
            <select id=layoutSize>
                <option>4x4</option>
                <option>6x6</option>
                <option>8x8</option>
            </select>
        </div>
        <input type="button" value="Play!" style="font-size: 20px; padding:5px" onclick="setGridSize();" />
    </form>
    <div id="menu">
        <table>
            <tr>
                <td>
                    <form>
                        <select id="diskColorSelector1">
                            <option value="black" selected>Black</option>
                            <option value="red">Red</option>
                            <option value="purple">Purple</option>
                        </select>
                    </form>
                </td>
                <td>
                    <input type="button" value="Change Player 1 Disk Color" onclick="changeDiskColor();" />
                </td>
            </tr>
            <tr>
                <td>
                    <form>
                        <select id="diskColorSelector2">
                            <option value="white">White</option>
                            <option value="blue">Blue</option>
                            <option value="orange">Orange</option>
                        </select>
                    </form>
                </td>
                <td>
                    <input type="button" value="Change Player 2 Disk Color" onclick="changeDiskColor();" />
                </td>
            </tr>
            <tr>
                <td>
                    <form>
                        <select id="gridColorSelector">
                            <option value="green" selected>Green</option>
                            <option value="lightgray">Light Gray</option>
                            <option value="lightblue">Light Blue</option>
                        </select>
                    </form>
                </td>
                <td>
                    <input type="button" value="Change Grid Color" onclick="changeGridColor();" />
                </td>
            </tr>
        </table>
        <div id="timer"></div>

        <table>
            <tr>
                <td>
                    <p id="player1Info">Player 1 has 0 disks</p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p id="player2Info">Player 2 has 0 disks</p>
                </td>
            </tr>
        </table>
    </div>
    <div id="board" role="main">
        <div id="gameEnd" style="text-align: center">
        </div>
    </div>
</body>
</div>

<script>
    var currentPlayer = 1;
    var startTime;
    var gridSize;
    var turn = 1;
    var table;
    var opponentType;

    var interval;

    var player1Score;
    var player2Score;
    var gameDuration;

    var gameOver = false;

    var directions = [{ // row up
            "initRow": "row = rowIndex - 1",
            "initColumn": "column = columnIndex",
            "operation": "row--",
            "check": "row >= 0"
        },
        { // row down
            "initRow": "row = rowIndex + 1",
            "initColumn": "column = columnIndex",
            "operation": "row++",
            "check": "row < gridSize"
        },
        { // column left
            "initRow": "row = rowIndex",
            "initColumn": "column = columnIndex - 1",
            "operation": "column--",
            "check": "column >= 0"
        },
        { // column right
            "initRow": "row = rowIndex",
            "initColumn": "column = columnIndex + 1",
            "operation": "column++",
            "check": "column <= gridSize"
        },
        { // top left diagonal
            "initRow": "row = rowIndex - 1",
            "initColumn": "column = columnIndex - 1",
            "operation": "column--; row--",
            "check": "row >= 0 && column >= 0"
        },
        { // top right diagonal
            "initRow": "row = rowIndex - 1",
            "initColumn": "column = columnIndex + 1",
            "operation": "column++; row--",
            "check": "row >= 0 && column <= gridSize"
        },
        { // bottom left diagonal
            "initRow": "row = rowIndex + 1",
            "initColumn": "column = columnIndex - 1",
            "operation": "column--; row++",
            "check": "row < gridSize && column >= 0"
        },
        { // bottom right diagonal
            "initRow": "row = rowIndex + 1",
            "initColumn": "column = columnIndex + 1",
            "operation": "column++; row++",
            "check": "row < gridSize && column <= gridSize"
        }
    ]
    $(document).ready(function() {
        $("#menu").hide();
        $("#board").hide();
        $("#gameEnd").hide();   
        //$("#sizeForm").hide();
    })

    // user selects 4x4, 6x6, or 8x8
    function setGridSize() {
        //$("#sizeForm").hide();
        $("#configForm").hide();
        $("#menu").show();
        $("#board").show()
        opponentType = $("input[name='opponentType']:checked").val();
        let selector = document.getElementById("layoutSize");
        gridSize = Number(selector.options[selector.selectedIndex].text[0]);
        drawGrid(gridSize);
        startTime = Date.now();
        interval = setInterval(updateTimer, 1)
    }

    function drawGrid(gridSize) {
        let container = document.getElementById("board");
        table = document.createElement("TABLE");
        table.setAttribute("id", "gridTable");
        let tableHead = document.createElement("THEAD");
        let tableBody = document.createElement("TBODY");
        let tableFoot = document.createElement("TFOOT");

        container.appendChild(table);
        table.appendChild(tableHead);
        table.appendChild(tableBody);
        table.appendChild(tableFoot);

        var headerRow = tableHead.insertRow();
        headerRow.insertCell().innerHTML = "<div class='buffer'></div>";
        for (let i = 0; i < gridSize; i++)
            headerRow.insertCell().innerText = String.fromCharCode('a'.charCodeAt(0) + i);
        headerRow.insertCell().innerHTML = "<div class='buffer'></div>";

        for (let i = 0; i < gridSize; i++) {
            var row = tableBody.insertRow();
            row.insertCell().innerHTML = "<div class='gridCellNumber'>" + i + "</div>";
            for (let j = 0; j < gridSize; j++)
                row.insertCell().innerHTML = "<div class='gridCell' role='checkbox' aria-checked='false'></div>";
            row.insertCell().innerHTML = "<div class='gridCellNumber'>" + i + "</div>";
        }
        $(".gridCell").attr("onclick", "playerTurn(this)");

        var footerRow = tableFoot.insertRow();
        footerRow.insertCell().innerHTML = "<div class='buffer'></div>";
        for (let i = 0; i < gridSize; i++)
            footerRow.insertCell().innerHTML = String.fromCharCode('a'.charCodeAt(0) + i);
        footerRow.insertCell().innerHTML = "<div class='buffer'></div>";

        // highlight center four cells
        highlight();

    }

    // highlight valid cells on new player's turn
    function setValidSpaces() {
        let existsPossibleSpace = false;

        let opponent = "diskPlayer" + (currentPlayer == 1 ? "2" : "1");
        let currentPlayerSpots = document.getElementsByClassName("diskPlayer" + currentPlayer);

        if (turn > 4) {
            $(".diskHighlight").remove() // remove previous player's highlighted spots
            for (let i = 0; i < currentPlayerSpots.length; i++) {
                let [rowIndex, columnIndex] = getCoordinates(currentPlayerSpots[i]);
                for (let i = 0; i < directions.length; i++) {
                    count = 0;
                    eval(directions[i].initRow);
                    eval(directions[i].initColumn);

                    while (eval(directions[i].check)) {
                        let possibleOpponent = table.childNodes[1].rows[row].cells[column].childNodes[0];
                        if (possibleOpponent.hasChildNodes() && possibleOpponent.childNodes[0].className == opponent)
                            count++;
                        else
                            break;
                        eval(directions[i].operation);
                    }
                    if (count > 0 && eval(directions[i].check)) {
                        let possibleSpace = table.childNodes[1].rows[row].cells[column].childNodes[0];
                        if (!possibleSpace.hasChildNodes()) {
                            highlight(row, column);
                        }

                    }
                }
            }
        }
    }

    // pass disk
    // return row and index of cell
    function getCoordinates(disk) {
        var columnIndex = parseInt($(disk).parent().parent().index());
        var rowIndex = parseInt($(disk).parent().parent().parent().index());
        return [rowIndex, columnIndex];
    }

    function playerTurn(gridCell) {
        if (isValidSpace(gridCell)) {
            drawDisk(gridCell);
            flipDisks(gridCell.childNodes[0]);
            currentPlayer = currentPlayer == 1 ? 2 : 1;
            turn++;
            setValidSpaces();
            if (opponentType == 'Computer' && !gameOver)
                setTimeout(function() {
                    computerTurn()
                }, 500);
        }

    }
    $(document).keypress(function(e) {
        if (e.which == 13) {
            computerTurn();
        }
    });
    // return whether selected cell is highlighted
    function isValidSpace(gridCell) {
        return gridCell.hasChildNodes() && gridCell.childNodes[0].className == "diskHighlight"
    }

    // highlight either center cells or specified cell
    function highlight(row = null, column = null) {
        // first four turns - highlight middle four spaces
        if (turn <= 4) {
            let center = Math.floor(gridSize / 2);
            let disks = new Array(4);
            for (let i = 0; i < 4; i++) {
                disks[i] = document.createElement("DIV");
                disks[i].className = "diskHighlight";
            }
            table.rows[center].cells.item(center).childNodes[0].appendChild(disks[0]);
            table.rows[center].cells.item(center + 1).childNodes[0].appendChild(disks[1]);
            table.rows[center + 1].cells.item(center).childNodes[0].appendChild(disks[2]);
            table.rows[center + 1].cells.item(center + 1).childNodes[0].appendChild(disks[3]);
        }

        // past first four turns - highlight specified cell
        else {
            let disk = document.createElement("DIV");
            disk.className = "diskHighlight";
            table.childNodes[1].rows[row].cells.item(column).childNodes[0].appendChild(disk);
        }
    }

    // pass td
    function drawDisk(gridCell) {
        // remove highlighted space
        if (gridCell.hasChildNodes() && gridCell.childNodes[0].className == "diskHighlight")
            gridCell.removeChild(gridCell.childNodes[0]);
        gridCell.setAttribute("aria-checked", "true");
        // draw disk
        let disk = document.createElement("DIV");
        disk.className = "diskPlayer" + currentPlayer;
        if (!gridCell.hasChildNodes()) {
            gridCell.appendChild(disk);
            console.log("Player " + currentPlayer + " placed disk");
            updatePlayerDiskCount();
        }
    }

    function updatePlayerDiskCount() {
        $("#player1Info").html(`Player 1 has ${$(".diskPlayer1").length} disks`)
        $("#player2Info").html(`Player 2 has ${$(".diskPlayer2").length} disks`)
        player1Score = $(".diskPlayer1").length;
        player2Score = $(".diskPlayer2").length
    }

    function computerTurn() {
        if (!gameOver) {
            let highlightedDisks = Array.from(document.getElementsByClassName("diskHighlight"));
            let numDisksFlipped = highlightedDisks.map(x => flipDisks(x, true));
            console.log(numDisksFlipped);
            let indexOfMax = numDisksFlipped.indexOf(Math.max.apply(null, numDisksFlipped));

            let gridCell = highlightedDisks[indexOfMax].parentNode
            drawDisk(gridCell);
            flipDisks(gridCell.childNodes[0]);
            currentPlayer = currentPlayer == 1 ? 2 : 1;
            turn++;
            setValidSpaces();
        }
    }

    // pass td
    // change color of disks between new disk and old disks
    function flipDisks(disk, isTentative = false) {
        let [rowIndex, columnIndex] = getCoordinates(disk);
        let opponent = "diskPlayer" + (currentPlayer == 1 ? "2" : "1");
        let numCellsFlipped = 0;

        for (let i = 0; i < directions.length; i++) {
            count = 0;
            eval(directions[i].initRow);
            eval(directions[i].initColumn);
            let flipOpponents = new Array();
            while (eval(directions[i].check)) {
                let possibleOpponent = table.childNodes[1].rows[row].cells[column].childNodes[0];
                if (possibleOpponent.hasChildNodes() && possibleOpponent.childNodes[0].className == opponent) {
                    flipOpponents.push(possibleOpponent.childNodes[0]);
                    count++;
                } else if (possibleOpponent.hasChildNodes() && possibleOpponent.childNodes[0].className == "diskPlayer" + currentPlayer && count > 0) {
                    if (!isTentative) {
                        for (let j = 0; j < flipOpponents.length; j++) {
                            console.log("flipped " + getCoordinates(flipOpponents[j]));
                            flipOpponents[j].className = "diskPlayer" + currentPlayer;
                        }
                        updatePlayerDiskCount();
                    } else {
                        numCellsFlipped += flipOpponents.length;
                    }
                } else
                    break;
                eval(directions[i].operation);
            }
        }
        return numCellsFlipped;
    }

    function changeGridColor() {
        var selector = document.getElementById("gridColorSelector");
        var newGridColor = selector.options[selector.selectedIndex].value;
        document.getElementById("gridTable").style.backgroundColor = newGridColor;

    }
    // change all player's disk color
    function changeDiskColor() {
        for (var p = 1; p <= 2; p++) {
            var selector = document.getElementById("diskColorSelector" + p);
            var diskColor = selector.options[selector.selectedIndex].value;
            $("option[value='" + diskColor + "']").attr("disabled", "disabled");

            // change color for existing disks and future disks
            var stylesheet = document.styleSheets;
            for (var i = 0; i < stylesheet.length; i++) {
                var styleList = stylesheet[i].cssRules || stylesheet[i].rules;
                for (var j = 0; j < styleList.length; j++)
                    if (styleList[j].selectorText == ".diskPlayer" + p)
                        styleList[j].style.backgroundColor = diskColor;
            }
        }
    }

    function updateTimer() {
        if ($(".diskHighlight")[0]) {
            let elapsedTime = Date.now() - startTime;
            let minutes = Math.floor((elapsedTime % 3600000) / 60000);
            let seconds = Math.floor((elapsedTime % 60000) / 1000);
            let milliseconds = Math.floor((elapsedTime % 60000) / 100);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            let timer = document.getElementById("timer");
            timer.innerText = minutes + ":" + seconds;
        } else {
            let data = {
                "gridSize": gridSize,
                "score": player1Score,
                "timePlayed": document.getElementById("timer").innerText,
                "isWon": player1Score > player2Score ? "True" : "False"
            };
            gameOver = true;
            saveGame(data);
            clearInterval(interval)
        }
    }

    function reloadGame(){
        console.log("clicked")
        location.reload()
    }
        

    function saveGame(data) {
        $.ajax({
            type: "POST",
            url: './server/gameover.php',
            data: data,
            success: function(response) {
                console.log(response)
                response = JSON.parse(response);

                if (response.hasOwnProperty("username")) {
                    let gameEndDisplay = document.getElementById("gameEnd");
                    let winningPlayer = data["isWon"] == "True" ? response["username"] + " won" : "Player 2 won";
                    if (player1Score == player2Score)
                        winningPlayer = "Draw";
                    $("#gameEnd").show();
                    gameEndDisplay.innerHTML = `<strong>Game Over! </strong>${winningPlayer} in ${data["timePlayed"]}<br/><button onClick="reloadGame()">Play Again</button>`;
                } else {
                    alert("Failed to save game")
                }
            }
        });
    }
</script>

</html>