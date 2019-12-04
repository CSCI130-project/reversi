<?php
    include "database.php";

    $errors = array();

    # check for empty fields
    if(!isset($_POST["username"]) || empty($_POST["username"]))
        $errors["username"] = "Required";
    if(!isset($_POST["password"]) || empty($_POST["password"]))
        $errors["password"] = "Required";
    if(count($errors) > 0)
        die(json_encode($errors));

    $username = validateInput($_POST["username"]);
    $password = validateInput($_POST["password"]);

    $conn = new mysqli($server, $usernameSQL, $passwordSQL, $database);
    if($conn->error)
        $errors["other"] = json_encode($conn->error);
    else
    {
        $sql = "SELECT password FROM Players WHERE username='$username'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            if(password_verify($password, $row["password"]))
            {
                session_start();
                $_SESSION["username"] = $username;
            }
            else
                $errors["password"] = "Incorrect password";
        }
        else
            $errors["username"] = "Username does not exist";
    }
    echo json_encode($errors);    

    function validateInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>