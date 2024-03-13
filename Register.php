<?php 
//   session_start();
  include('database.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Registration</title>
    <link rel="stylesheet" href="Style/login_register.css">
</head>
<body>
    <div class="container">
        <form action="Register.php" method="post" class="register-form">
            <h2>Register for Our Bank</h2>
            <input type="text" placeholder="Username" required name="Username-Client">
            <input type="password" placeholder="Password" required name="Password-Client">
            <!-- <input type="password" placeholder="Confirm Password" required name="pa-Client"> -->
            <input type="text" placeholder="Your Name" required name="Name-Client">
            <input type="email" placeholder="Email" required name="Email-Client">
            <input type="text" placeholder="EGN" required name="EGN-Client">
            <input type="text" placeholder="Address" required name="Address-Client">
            <input type="tel" placeholder="Phone number" required name="Phone-Client">
            <button type="submit" name="register">Register</button>
            <p>Already have an account? <a href="login.php">Log in here</a></p>
        </form>
    </div>
</body>
</html>

<?php 
if(isset($_POST["register"])){

    $username = $_POST["Username-Client"];
    $password = $_POST["Password-Client"];
    $name = $_POST["Name-Client"];
    $email = $_POST["Email-Client"];
    $egn = $_POST["EGN-Client"];
    $address = $_POST["Address-Client"];
    $phone = $_POST["Phone-Client"];

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $getClient = "SELECT * FROM client WHERE username = '$username'";
    $Client = mysqli_query($conn, $getClient);

    $getEmployee = "SELECT * FROM employee WHERE username = '$username'";
    $Employee = mysqli_query($conn, $getEmployee);

    if (mysqli_num_rows($Client) == 0 && mysqli_num_rows($Employee) == 0) {
        $insertClient = "INSERT INTO client (Name, EGN, Address, Phone_Number, Email, Username, Password)
            VALUES ('$name', '$egn','$address', '$phone', '$email', '$username', '$hash')";
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
    else {
        ?>
    <script> alert("Username-ът вече е зает!")</script>
    <?php 
    }
}
?>
