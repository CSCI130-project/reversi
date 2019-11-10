<?php
$servername = "localhost";
$username = "username";
$password = "password";
$db = "reversi";

$conn = new mysqli($servername, $username, $password, $db);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_POST && $_POST['action'] == 'register') {
    $firstName = $_POST['firstName'];
    $lastname = $_POST['lastName'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $location = $_POST['location'];
    $image = $_POST['image'];


    $sql = "insert into players values (null, '{$login}', '{$password}', '{$firstName}', '{$lastname}', {$age}, '{$gender}', '{$location}', '{$image}')";
    if ($conn->query($sql)) {
        echo 'true';
        $conn->close();
    } else {
        echo 'false';
    }
}
if ($_POST && $_POST['action'] == 'login') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $sql = "select login, password from players where login='{$login}' && password='{$password}'";
    $res = $conn->query($sql);
    if ($res && mysqli_num_rows($res) > 0) {
        echo 'true';
        $conn->close();
    } else {
        echo 'false';
    }
}


if ($_POST && $_POST['action'] == 'saveGame') {
    $player = $_POST['player'];
    $duration = $_POST['duration'];
    $score = $_POST['score'];
    $winner = $_POST['winner'];


    $sql = "insert into games values (null, '{$player}', '{$duration}', {$score}, {$winner})";

    $res = $conn->query($sql);
    if ($res) {
        echo 'true';
        $conn->close();
    } else {
        echo 'false';
    }
}

if ($_GET && $_GET['action'] == "getHistory") {
    $username = $_GET['username'];

    $sql = "select * from games where player='{$username}'";

    $res = $conn->query($sql);
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)){
            $table .= '<tr><td>'.$row['player'].'</td><td>'.$row['duration'].'</td><td>'.$row['score'].'</td><td>'.(boolval($row['winner'])?'true' : 'false').'</td>';
        }
        echo $table;
        $conn->close();
    } else {
        echo 'false';
    }
}
