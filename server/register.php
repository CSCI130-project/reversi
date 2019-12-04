<?php
    include "Player.php";
    include "database.php";

    $errors = array();

    # check that all required fields are filled
    $requiredFields = ["username", "password", "firstname", "lastname", "age", "gender", "location"];
    foreach($requiredFields as $field)
        if(!isset($_POST[$field]) || empty($_POST[$field]))
            $errors[$field] = "Required";
    if(!isset($_FILES["fileup"]) || empty($_FILES["fileup"]))
        $errors["photo"] = "Required";
    if(count($errors) > 0)
        die(json_encode($errors));

    // extract data
    $username = validateInput($_POST["username"]);
    $password = password_hash(validateInput($_POST["password"]), PASSWORD_DEFAULT);
    $firstname = validateInput($_POST["firstname"]);
    $lastname = validateInput($_POST["lastname"]);
    $age = validateInput($_POST["age"]);
    $gender = validateInput($_POST["gender"]);
    $location = validateInput($_POST["location"]);
    $photo = $username . "-" . basename($_FILES["fileup"]["name"]);

    # check that age is a number
    if(!ctype_digit($age))
    {
        $errors["age"] = "Enter a number";
        die(json_encode($errors));
    }

    // create new Player object
    $player = new Player(
        $username,
        $password,
        $firstname,
        $lastname,
        $age,
        $gender,
        $location,
        $photo
    );

    uploadFile();
    if(count($errors) == 0)
        saveToDatabase();
    echo json_encode($errors);

function validateInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// add to Players table
function saveToDatabase()
{
    global $username, $password, $firstname, $lastname, $age, $gender, $location, $photo, $errors;

    global $server, $usernameSQL, $passwordSQL, $database;

    $conn = new mysqli($server, $usernameSQL, $passwordSQL, $database);
    if($conn->connect_error)
        $errors["other"] = $conn->connect_error;
    else
    {
        $query = "SELECT COUNT(*) as num FROM Players WHERE username='$username'";
        $result = $conn->query($query);
        if($conn->error)
            echo json_encode($conn->error);
        

        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            if((int)$row["num"] > 0)
                $errors["username"] = "Username already exists";                
            else
            {
                $query = "INSERT INTO Players(username, password, firstname, lastname, age, gender, location, photo) VALUES('$username', '$password', '$firstname', '$lastname', $age, '$gender', '$location', '$photo')";
    
                if(!$conn->query($query))
                    $errors["other"] = $conn->error;
            }
        }
    }
    $conn->close();
}
function uploadFile()
{
    global $errors, $username;
    $target_dir = "../uploads/";
    $target_file = $target_dir . $username . "-" . basename($_FILES["fileup"]["name"]);
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    $uploadOk = true;

    if(isset($_POST["submit"])) 
    {
        $check = getimagesize($_FILES["fileup"]["tmp_name"]);
        if($check == false)
        {
            $uploadOk = false;
            $errors["photo"] = "File is not an image";
        }
    }
    /*
    // Verify if file already exists
    if (file_exists($target_file))
    {
        $uploadOk = false;
        $errors["photo"] = "File already exists";
    }
    */
    // Verify the file size
    if ($_FILES["fileup"]["size"] > 500000) 
    {
        $uploadOk = false;
        $errors["photo"] = "File too large";
    }
    // Verify certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png") 
    {
        $uploadOk = false;
        $errors["photo"] = "Image must be jpg or png";
    }
    
    if($uploadOk)
    {
        if (!move_uploaded_file($_FILES["fileup"]["tmp_name"], $target_file))
            $errors["photo"] = "Error uploading file";
    }
}
?>