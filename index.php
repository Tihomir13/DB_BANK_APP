<?php 
  include("User_Acc_Info.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Homepage</title>
    <link rel="stylesheet" href="Style/styles.css">
</head>
<body>
<div class="container">
    <header>
        <h1>Welcome to Our Bank</h1>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="Credits.php">Credits</a></li>
                <li><a href="Transactions.php">Transactions</a></li>
                <li><a href="Profile.php"><?php echo (isset($currAccAmount)) ? 'Profile' : 'Clients'; ?></a></li>
                <li><a href="LOGIN.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="home-info">
            <h2>Banking at Your Fingertips</h2>
            <p>Welcome to Our Bank, where managing your finances is made easy. Whether you need to check your account balance, transfer funds, or apply for a loan, we've got you covered.</p>
        </section>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> BankName. All rights reserved.</p>
    </footer>
</div>
</body>
</html>
