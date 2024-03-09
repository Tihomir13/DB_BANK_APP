<?php
    $db_sever = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "bank";
    global $conn;

    try {
        $conn = mysqli_connect($db_sever, $db_user, $db_pass, $db_name);
        // echo "Connected to the database";
    }
    catch(mysqli_sql_exception){
        echo "Could not connect! <br>";
    }
?>