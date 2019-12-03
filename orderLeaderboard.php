<?php
    include "database.php";

    $gridSize = intval($_POST["gridSize"]);
    $orderBy = $_POST["orderBy"];

    switch($orderBy)
    {
        case "score": $orderClause = "score DESC"; break;
        case "score_reverse": $orderClause = "score"; break;
        case "time": $orderClause = "timePlayed DESC"; break;
        case "time_reverse": $orderClause = "timePlayed"; break;
    }

    $conn = new mysqli($server, $usernameSQL, $passwordSQL, $database);
    if($conn->error)
        echo $conn->error;
    else
    {
        $sql = "SELECT photo, username, score, timePlayed, gameID, gridSize, isWon FROM Players JOIN Games USING (username) WHERE gridSize=$gridSize ORDER BY " . $orderClause;
        $result = $conn->query($sql);
        if($conn->error)
            echo $conn->error;
        else
        {
            $data = "None";
            if($result->num_rows > 0)
            {
                $data = "<TABLE>
                            <TR>
                                <TH>Photo</TH>
                                <TH>Username</TH>
                                <TH>Score</TH>
                                <TH>Time Played</TH>
                                <TH>Game ID</TH>
                                <TH>Grid Size</TH>
                                <TH>Won</TH>
                            </TR>";
                while($row = $result->fetch_assoc())
                {
                    $row["photo"] = "<img src='" . "uploads/" . $row["photo"] . "'/>";
                    $data .= "<TR>";
                    foreach($row as $value)
                    {
                        $data .= "<TD>" . $value . "</TD>";
                    }
                    $data .= "</TR>";
                }
                $data .= "</TABLE>";
            }
            echo stripslashes($data);
        }
    }

?>