<?php 
  session_unset();
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
      <form class="login-form" action="Login.php" method="post">
        <h2>Welcome to Our Bank</h2>
        <input type="text" placeholder="Username" required name="Username-Client"/>
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
  
  $username = $_POST["Username-Client"];
  $password = $_POST["Password-Client"];

  // $hash = password_hash($password, PASSWORD_DEFAULT);
  
  // Проверка за съществуващ потребител
  $getClient = "SELECT * FROM client WHERE username = '$username'";
  $Client = mysqli_query($conn, $getClient);

  $getEmployee = "SELECT * FROM employee WHERE username = '$username'";
  $Employee = mysqli_query($conn, $getEmployee);

  // Проверка за грешки и съществуващ потребител
  if ($Client && mysqli_num_rows($Client) == 1) {
    $userdata = mysqli_fetch_assoc($Client);
    $hashedpass = $userdata['password'];
    
    // Проверка за съвпадение на хешираната парола
    if (password_verify($password, $hashedpass)) {
      session_start();
      $_SESSION['username'] = $userdata['username'];
      $_SESSION['name'] = $userdata['Name'];
      $_SESSION['email'] = $userdata['Email'];
      
      // Пренасочване към страницата за транзакции
      header("Location: Transactions.php");
      exit();
    } else {
      echo "Грешно потребителско име или парола.";
    }
  } 
  else if ($Employee && mysqli_num_rows($Employee) == 1) {
    $userdata = mysqli_fetch_assoc($Employee);
    $hashedpass = $userdata['password'];
    
    // Проверка за съвпадение на хешираната парола
    if (password_verify($password, $hashedpass)) {
      session_start();
      $_SESSION['username'] = $userdata['username'];
      $_SESSION['name'] = $userdata['Name'];
      $_SESSION['email'] = $userdata['Email'];
      
      // Пренасочване към страницата за транзакции
      header("Location: Transactions.php");
      exit();
    } else {
      echo "Грешно потребителско име или парола.";
    }
  }
  else {
    echo "Грешно потребителско име или парола.";
  }
}
?>
