<?php 
session_start();
include('database.php');

if (!isset($_SESSION['username'])) {
  // Ако потребителят не е логнат, пренасочете го към страницата за логин
  header("Location: login.php");
  exit();
}

$username = $_SESSION['username'];
$name = $_SESSION['name'];
$email = $_SESSION['email'];
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles.css" />
  </head>
  <body>
    <div class="container">
      <header>
        <h1>Welcome, <?php echo $username?></h1>
        <nav>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Credits</a></li>
            <li><a href="#">Transactions</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="LOGIN.php">Logout</a></li>
          </ul>
        </nav>
      </header>
      <main>
        <section class="make-transaction">
          <h2>Make a Transaction</h2>
          <form action="make_transaction.php" method="post">
            <label for="amount">Amount:</label>
            <input type="text" id="amount" name="amount" required />
            <label for="recipient">Recipient:</label>
            <input type="text" id="recipient" name="recipient" required />
            <button type="submit">Submit</button>
          </form>
        </section>
        <section class="transactions">
          <h2>Recent Transactions</h2>
          <table>
            <thead>
              <tr>
                <th>Date</th>
                <th>Transaction Type</th>
                <th>Sender</th>
                <th>Receiver</th>
                <th>Employee</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>2024-03-10</td>
                <td>Deposit</td>
                <td>John Doe</td>
                <td>-</td>
                <td>Employee Name</td>
                <td>$100.00</td>
              </tr>
              <!-- Add more rows for additional transactions -->
            </tbody>
          </table>
        </section>
      </main>
      <footer>
        <p>&copy; 2024 BankName. All rights reserved.</p>
      </footer>
    </div>
  </body>
</html>
