<?php
    # check if user is logged in
    session_start();
    if(isset($_SESSION["username"]))
        header("location: game.php");    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Reversi</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <div class="container" role="main">
            <h2>Login</h3>
                <div class="card" style="padding: 15px;">
                    <div>
                        <form id="loginForm">
                            <div class="form-group">
                                <label>Username</label>
                                <span id="usernameError"></span>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <span id="passwordError"></span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                            </div>
                            <div>
                                <span id="otherError"></span>
                            </div>
                        </form>
                        <button class="btn btn-primary" onclick="login()">Login</button>
                        <button id="goToRegister" class="btn btn-secondary">Register</button>
                    </div>
                </div>
        </div>
        <script>
            $('#goToRegister').click((e)=>{
                window.location='register.html';
            })

            function login()
            {
                var formElement = document.querySelector("form");
                var formData = new FormData(formElement);
      
                $.ajax({
                    url: './server/login.php',
                    data: formData,
                    type: 'POST',
                    contentType: false,
                    processData: false,
                    success: function(data)
                    {
                        $("span").empty();
                        errorArray = JSON.parse(data);
                        if(errorArray.length == 0)
                            window.location = "game.php";
                        else
                        {
                            keys = Object.keys(errorArray);
                            for(let i = 0; i < keys.length; i++)
                                document.getElementById(keys[i] + "Error").innerHTML = errorArray[keys[i]];
                        }
                    },
                });
            }
        </script>
    </body>
</html>
