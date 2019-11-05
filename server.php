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

if($_POST && $_POST['action'] == 'register'){
    $firstName = $_POST['firstName'];
    $lastname = $_POST['lastName'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $location = $_POST['location'];

    $sql = "insert into players values (null, '{$login}', '{$password}', '{$firstName}', '{$lastname}', {$age}, '{$gender}', '{$location}')";
    if($conn->query($sql)){
        echo 'true';
        $conn->close(); 
    }else{
        echo 'false';
    }
    
}
if($_POST && $_POST['action'] == 'login'){
    $login = $_POST['login'];
    $password = $_POST['password'];

    $sql = "select login, password from players where login='{$login}' && password='{$password}'";
    $res = $conn->query($sql);
    if($res && mysqli_num_rows($res) > 0){
        echo 'true';
        $conn->close(); 
    }else{
        echo 'false';
    }
}
// if($_GET){
//     $sql = "select * from players";
    
//     while($row = $conn->query($sql)){
//         foreach($row as $cname => $cvalue){
//             print "$cname: $cvalue\t";
//         }
//         print "\r\n";
//     }

// }
