<?php
    include("database.php");
    include("index.php");

    
    if(isset($_POST["add-Client"])){

        $name = $_POST["Name-Client"];
        $egn = $_POST["EGN-Client"];
        $address = $_POST["Address-Client"];
        $phone = $_POST["Phone-Client"];
        $email = $_POST["Email-Client"];

        $insertClient = "INSERT INTO client (Name, EGN, Address, Phone_Number, Email)
            VALUES ('$name', '$egn','$address', '$phone', '$email')";
        try {
            if (!$conn) {
                throw new Exception("Database connection not established");
            }
            if (mysqli_query($conn, $insertClient)) {
                // echo "Client is now registered";
            } else {
                throw new Exception("Could not register user. Error: " . mysqli_error($conn));
            }
        } catch (Exception $e) {
            //echo $e->getMessage();
        }
    }
    if(isset($_POST["update-Client"])){
        $name = $_POST["Name-Client"];
        $egn = $_POST["EGN-Client"];
        $address = $_POST["Address-Client"];
        $phone = $_POST["Phone-Client"];
        $email = $_POST["Email-Client"];

        $updateClient = "UPDATE client 
                        SET Name = '$name', 
                        EGN = '$egn', 
                        Address = '$address', 
                        Phone_Number = '$phone', 
                        Email = '$email'
                        WHERE EGN = '$egn'";
        try {
            if (!$conn) {
                throw new Exception("Database connection not established");
            }
            if (mysqli_query($conn, $updateClient)) {
                // echo "Client is now registered";
            } else {
                throw new Exception("Could not register user. Error: " . mysqli_error($conn));
            }
        } catch (Exception $e) {
            //echo $e->getMessage();
        }
    }
    if(isset($_POST["delete-Client"])){
        $name = $_POST["Name-Client"];
        $egn = $_POST["EGN-Client"];
        $address = $_POST["Address-Client"];
        $phone = $_POST["Phone-Client"];
        $email = $_POST["Email-Client"];

        $deleteClient = "DELETE FROM client
                        WHERE EGN = '$egn'";
        try {
            if (!$conn) {
                throw new Exception("Database connection not established");
            }
            if (mysqli_query($conn, $deleteClient)) {
                // echo "Client is now registered";
            } else {
                throw new Exception("Could not register user. Error: " . mysqli_error($conn));
            }
        } catch (Exception $e) {
            //echo $e->getMessage();
        }
    }
?>