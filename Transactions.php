<?php 
  include("User_Acc_Info.php");
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
            <li><a href="home.php">Home</a></li>
            <li><a href="Credits.php">Credits</a></li>
            <li><a href="#">Transactions</a></li>
            <li><a href="Profile.php">Profile</a></li>
            <li><a href="LOGIN.php">Logout</a></li>
          </ul>
        </nav> 
      </header>
      <main >
        <section class="make-transaction">
          <div class="transaction-header-section" style="display: flex; justify-content: space-between">
            <?php 
            if(isset($currAccAmount))
              echo '<h2>Make a Transaction</h2>'
            ?> 
            <h2 id="accType"style="position:relative; right: 125px;">
              <?php
                if (isset($currAccAmount)) 
                  echo "Amount: $currAccAmount $currAccCurrency"; 
                else {
                  echo "
                    <script>
                      let element = document.querySelector('#accType');
                      element.style.color = 'red';
                      element.style.right = '-815px';
                    </script>";
                  echo "Banker Account";
                }
              ?>
            </h2>
          </div>
          <?php 
          if (isset($currAccAmount))
          echo '
              <form action="Transactions.php" method="post">
                <label for="amount">Amount:</label>
                <input type="text" id="amount" name="amount" required />
                <label for="recipient">Recipient:</label>
                <input type="text" id="recipient" name="recipient" required />
                <button type="submit" name="transferButton">Send</button>
              </form>';
            ?>
        </section>
        <section class="transactions">
          <h2>Recent Transactions</h2>
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Transaction Type</th>
                <th>Sender</th>
                <th>Recipient</th>
                <th>Employee Name</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
                  if(isset($currAccAmount)) {
                    $result = mysqli_query($conn, "SELECT transaction.*, 
                      trans_type.Type AS Trans_Type_Name,
                      employee.Name AS Employee_Name
                      FROM transaction 
                      INNER JOIN trans_type 
                      ON transaction.Trans_Type_ID = trans_type.ID 
                      INNER JOIN employee 
                      ON transaction.Employee_EGN = employee.EGN 
                      WHERE transaction.S_Bank_Account_IBAN = '$currAccIBAN' 
                      OR transaction.R_Bank_Account_IBAN = '$currAccIBAN'");
                      if($result) {
                        while($row = mysqli_fetch_assoc($result)){
                          ?>
                              <td><?php echo $row ['ID'];?></td>
                              <td><?php echo $row ['Amount'];?></td>
                              <td><?php echo $row ['Date'];?></td>
                              <td><?php echo $row ['Trans_Type_Name'];?></td>
                              <td><?php echo $row ['S_Bank_Account_IBAN'];?></td>
                              <td><?php echo $row ['R_Bank_Account_IBAN'];?></td>
                              <td><?php echo $row ['Employee_Name'];?></td>
                            </tr>
                            <?php
                            }
                          }
                          else echo"Error";
                  }
                  else {
                    $result = mysqli_query($conn, "SELECT transaction.*, 
                      trans_type.Type AS Trans_Type_Name,
                      employee.Name AS Employee_Name
                      FROM transaction 
                      INNER JOIN trans_type 
                      ON transaction.Trans_Type_ID = trans_type.ID 
                      INNER JOIN employee 
                      ON transaction.Employee_EGN = employee.EGN");
                      if($result) {
                        while($row = mysqli_fetch_assoc($result)){
                          ?>
                              <td><?php echo $row ['ID'];?></td>
                              <td><?php echo $row ['Amount'];?></td>
                              <td><?php echo $row ['Date'];?></td>
                              <td><?php echo $row ['Trans_Type_Name'];?></td>
                              <td><?php echo $row ['S_Bank_Account_IBAN'];?></td>
                              <td><?php echo $row ['R_Bank_Account_IBAN'];?></td>
                              <td style="text-align: center"><?php echo ($row['Employee_Name'] == $name) ? 'You' : $row['Employee_Name']; ?></td>
                            </tr>
                            <?php
                            }
                          }
                      else echo"Error";
                  }
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

<?php
if(isset($currAccAmount)) {
  processTransfer($conn, $currAccIBAN, $currAccAmount);
}
?>