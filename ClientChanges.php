<?php
    include("database.php");
    include("index.php");

    
    if(isset($_POST["add-Client"])){

        $name = $_POST["Name-Client"];
        $egn = $_POST["EGN-Client"];
        $address = $_POST["Address-Client"];
        $phone = $_POST["Phone-Client"];
        $email = $_POST["Email-Client"];

        $InsertClient = "INSERT INTO client (Name, EGN, Address, Phone_Number, Email)
            VALUES ('$name', '$egn','$address', '$phone', '$email')";
        try {
            if (!$conn) {
                throw new Exception("Database connection not established");
            }
            if (mysqli_query($conn, $InsertClient)) {
                echo "Client is now registered";
            } else {
                throw new Exception("Could not register user. Error: " . mysqli_error($conn));
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        function restartPage() {
            // Пренасочва браузъра към текущата страница
            header("Location: " . $_SERVER['REQUEST_URI']);
          }
    }

?>