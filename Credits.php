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
    <title>Credits</title>
    <link rel="stylesheet" href="Style\styles.css" />
    <script defer src="interest.js"></script>
  </head>
  <body>
    <header>
      <h1>Credits</h1>
      <nav>
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="Transactions.php">Transactions</a></li>
          <li><a href="profile.html">Profile</a></li>
          <li><a href="Login.php">Logout</a></li>
        </ul>
      </nav>
    </header>

    <main>
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
    </main>

    <footer>
      <p>&copy; 2024 Your Bank. All rights reserved.</p>
    </footer>
  </body>
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