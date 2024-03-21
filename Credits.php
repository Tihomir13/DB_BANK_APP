<?php
    session_start();
    include('database.php');
    include('helperFunctions.php');

    $username = $_SESSION['username'];
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    $egn = $_SESSION['egn'];

    $currentAccInfo = mysqli_fetch_assoc(
    mysqli_query($conn, "
      SELECT bank_account.*, currency.Name AS CurrencyName
      FROM bank_account
      JOIN currency ON bank_account.currency_ID = currency.ID
      WHERE bank_account.Client_EGN = '$egn';
    "));
    
    $currAccAmount = $currentAccInfo['Amount'];
    $currAccIBAN = $currentAccInfo['IBAN'];
    $currAccCurrency = $currentAccInfo['CurrencyName'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Dashboard</title>
    <link rel="stylesheet" href="Style\styles.css" />
    <script defer src="interest.js"></script>
  </head>
  <body>
    <div class="container">
      <header>
        <h1
          >Welcome,
          <?php echo $name?></h1
        >
        <nav>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="Credits.php">Credits</a></li>
            <li><a href="#">Transactions</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="LOGIN.php">Logout</a></li>
          </ul>
        </nav>
      </header>
      <main style="height: 68vh">
        <section class="credit-form">
          <h2>Apply for Credit</h2>
          <form action="process_credit_application.php" method="post">
            <div>
              <label for="amount">Amount:</label>
              <input type="text" id="amount" name="amount" required />
            </div>
            <div>
              <label for="duration">Duration (months):</label>
              <select id="duration">
                <option value="option1">3 months</option>
                <option value="option2">6 months</option>
                <option value="option3">1 year</option>
                <option value="option4">2 year</option>
                <option value="option5">3 year</option>
                <option value="option6">4 year</option>
              </select>
            </div>
            <div>
              <label for="interest_rate"
                >Interest Rate (%): <span id="interest_rate">0</span></label
              >
            </div>
            <div>
              <button type="submit" name="apply_credit">Apply</button>
            </div>
          </form>
        </section>
        <section class="transactions">
          <h2>Recent Transactions</h2>
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>Amount</th>
                <th>Interest (%)</th>
                <th>Repayment_term Type</th>
                <th>Credit Type</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php
                    $result = mysqli_query($conn, "SELECT credit.*,
                    credit_type.Type AS Credit_Type_Name
                    FROM credit 
                    INNER JOIN credit_type 
                    ON credit.Credit_Type_ID = credit_type.ID  
                    WHERE credit.Bank_Account_IBAN = '$currAccIBAN'");

                    if($result) {
                    while($row = mysqli_fetch_assoc($result)){
                      ?>
                            <td><?php echo $row ['ID'];?></td>
                            <td><?php echo $row ['Amount'];?></td>
                            <td><?php echo $row ['Interest'];?></td>
                            <td><?php echo $row ['Repayment_term'];?></td>
                            <td><?php echo $row ['Credit_Type_Name'];?></td>
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

  <script> InterestUpdate();</script>
</html>

<?php 
  if(isset($_POST['apply_credit']))
  {
    $HasCreditQuery = ("SELECT * FROM credit WHERE Bank_Account_IBAN = '$currAccIBAN'");
    $result = mysqli_query($conn, $HasCreditQuery);

    if ($result && mysqli_num_rows($result) == 1){
      echo '
        <script>
          alert("Трябва да си изплатите кредита преди да вземете нов!");
        </script>';
      header('Location: Credits.php');
      exit();
    }

    $amount;
    $interest;

    $getCreditQuery = ("INSERT INTO credit (Amount, Interest, Repayment_term, Bank_Account_IBAN, Credit_Type_ID)
    VALUES ('$amount', '$interest','$address', '$phone', '$email', '$currAccIBAN', '$hash')");
  }
?>