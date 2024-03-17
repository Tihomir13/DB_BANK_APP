<?php 
session_start();
include('database.php');

$username = $_SESSION['username'];
$name = $_SESSION['name'];
$email = $_SESSION['email'];
$egn = $_SESSION['egn'];

$getBankInfoQuery = mysqli_query($conn, "SELECT * FROM bank_account WHERE Client_EGN = '$egn'");
$BankInfo = mysqli_fetch_assoc($getBankInfoQuery);
$Amount = $BankInfo['Amount'];

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Dashboard</title>
    <link rel="stylesheet" href="Style\styles.css" />
  </head>
  <body>
    <div class="container">
      <header>
        <h1>Welcome, <?php echo $name?></h1>
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
      <main style="height: 68vh;">
        <section class="make-transaction">
          <div class="transaction-header-section" style="display: flex; justify-content: space-between">
            <h2>Make a Transaction</h2> 
            <h2 style="position:relative; right: 200px;">Amount: <?php echo $Amount?></h2>
          </div>
          <form action="transaction.php" method="post">
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
                <?php
                  if(mysqli_query($conn, "SELECT * FROM transaction")) {
                    $result = mysqli_query($conn, "SELECT * FROM transaction");
                    while($row = mysqli_fetch_assoc($result)){
                      ?>
                            <td><?php echo $row ['Date'];?></td>
                            <td><?php echo $row ['EGN'];?></td>
                            <td><?php echo $row ['Address'];?></td>
                            <td><?php echo $row ['Phone_number'];?></td>
                            <td><?php echo $row ['Email'];?></td>
                          </tr>
                          <?php
                          }
                        }
                        else echo"Error";
                        ?>
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
