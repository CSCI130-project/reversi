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
echo "Connected successfully";

if($_POST){
    $firstName = $_POST['firstName'];
    $lastname = $_POST['lastName'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $location = $_POST['location'];

    $sql = "insert into players values (null, '{$login}', '{$password}', '{$firstName}', '{$lastname}', {$age}, '{$gender}', '{$location}')";
    if($conn->query($sql)){
        $result->close(); 
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
?>
