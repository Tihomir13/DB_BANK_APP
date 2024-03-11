<?php 
  session_start();
  include('database.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bank Login</title>
    <link rel="stylesheet" href="login_register.css">
  </head>
  <body>
    <div class="container">
      <form class="login-form" action="Transactions.php" method="post">
        <h2>Welcome to Our Bank</h2>
        <input type="text" placeholder="Username" required name=Name-Client/>
        <input type="password" placeholder="Password" required name="Password-Client"/>
        <button type="submit" name="login">Log In</button>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
        <p>Forgot password? <a href="#">Reset here</a></p>
      </form>
    </div>
  </body>
</html>

<?php 
if(isset($_POST["login"])){
  
  $username = $_POST["Name-Client"];
  $password = $_POST["Password-Client"];
  
  $hash = password_hash($password, CRYPT_SHA256);
  
  $sql = "SELECT * FROM client WHERE Username = '$username' AND Password = '$hash'";
  try {
    if (!$conn) {
      throw new Exception("Database connection not established");
    }
    if (mysqli_query($conn, $sql)) {
      $_SESSION['username'] = $username;
      $_SESSION['name'] = $name;
      $_SESSION['email'] = $email;
      header("Location: Transactions.php");
    } else {
      throw new Exception("Error wrong username or password " . mysqli_error($conn));
    }
  } catch (Exception $e) {
    //echo $e->getMessage();
  }
}
?>