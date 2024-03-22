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
            <li><a href="#">Credits</a></li>
            <li><a href="Transactions.php">Transactions</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="LOGIN.php">Logout</a></li>
          </ul>
        </nav>
      </header>
      <main style="height: 68vh">
        <section class="credit-form">
          <h2>Apply for Credit</h2>
          <form action="#" method="get">
            <div>
              <label for="amount">Amount:</label>
              <input type="text" id="amount" name="amount" placeholder="1000-100,000" style="text-align:center"required />
            </div>
            <div>
              <label for="duration">Duration (months):</label>
              <select id="duration" name="duration">
                <option value="option0"></option>
                <option value="option1">3 months</option>
                <option value="option2">6 months</option>
                <option value="option3">1 year</option>
                <option value="option4">2 year</option>
                <option value="option5">3 year</option>
                <option value="option6">4 year</option>
              </select>
            </div>
            <div>
            <label for="loan_type">Loan type:</label>
              <select id="loan_type" name="loan_type">
                <option value="option0"></option>
                <option value="option1">Personal</option>
                <option value="option2">Mortgage</option>
                <option value="option3">Student</option>
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
                <th>Remaining Amount</th>
                <th>Interest (%)</th>
                <th>Repayment term</th>
                <th>Credit Type</th>
                <th>Monthly installment</th>
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
                            <td><?php echo $row ['Repayment_Period'];?></td>
                            <td><?php echo $row ['Credit_Type_Name'];?></td>
                            <td><?php echo '<a href="Credits.php?id=' . $row['ID'] . '">Pay</a>'?></td>
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

    <script>
      function InterestUpdate() {
      const rateElement = document.getElementById("interest_rate");
      const durationInput = document.getElementById("duration");
      rateElement.textContent = "";

      durationInput.addEventListener("change", function () {
          let durationInputVal = durationInput.selectedOptions[0].value;
          switch (durationInputVal) {
              case "option0":
                  rateElement.textContent = "";
                  break;
              case "option1":
                  rateElement.textContent = "1%";
                  break;
              case "option2":
                  rateElement.textContent = "1.5%";
                  break;
              case "option3":
                  rateElement.textContent = "3%";
                  break;
              case "option4":
                  rateElement.textContent = "5%";
                  break;
              case "option5":
                  rateElement.textContent = "7.5%";
                  break;
              case "option6":
                  rateElement.textContent = "10%";
                  break;
          }
      });
    }

    InterestUpdate();
</script>
  </body>
</html>

<?php 
  if(isset($_GET['apply_credit'])){

    $amount = $_GET['amount'];

    if($amount < 1000 || $amount > 100000){
      echo '
        <script>
          alert("Enter Amount between 1000 and 100,000!");
        </script>';
      exit();
    }

    if($_GET['duration'] == "option0"){
      echo '
        <script>
          alert("Enter Duration!");
        </script>';
      exit();
    }

    if($_GET['loan_type'] == "option0"){
      echo '
        <script>
          alert("Enter Loan type!");
        </script>';
      exit();
    }

    $HasCreditQuery = ("SELECT * FROM credit WHERE Bank_Account_IBAN = '$currAccIBAN'");
    $result = mysqli_query($conn, $HasCreditQuery);

    if ($result && mysqli_num_rows($result) == 1){
      echo '
        <script>
          alert("Трябва да си изплатите кредита преди да вземете нов!");
        </script>';
      exit();
    }

    $duration = $_GET['duration'];

    switch($duration) {
      case "option1":
        $coefficient = 1.01;
        $interest = 1;
        $time = "+3 months";
        $months = 3;
        break;
      case "option2":
        $coefficient = 1.015;
        $interest = 1.5;
        $time = "+6 months";
        $months = 6;
        break;
      case "option3":
        $coefficient = 1.03;
        $interest = 3;
        $time = "+1 year";
        $months = 12;
        break;
      case "option4":
        $coefficient = 1.05;
        $interest = 5;
        $time = "+2 years";
        $months = 24;
        break;
      case "option5":
        $coefficient = 1.075;
        $interest = 7.5;
        $time = "+3 years";
        $months = 36;
        break;
      case "option6":
        $coefficient = 1.1;
        $interest = 10;
        $time = "+4 years";
        $months = 48;
        break;
    };

    $type = $_GET['loan_type'];
    switch($type) {
      case "option1":
        $loan_type = 1;
        break;
      case "option2":
        $loan_type = 2;
        break;
      case "option3":
        $loan_type = 3;
        break;
    }

    $current_date = date("Y-m-d"); 
    $new_date = date("Y-m-d", strtotime($time, strtotime($current_date))); 

    // Пресмятане на новият amount 
    $loan = $amount * $coefficient;
    
    $insertCreditQuery = ("INSERT INTO credit (Amount, Interest, Repayment_Period, Bank_Account_IBAN, Credit_Type_ID)
    VALUES ('$loan', '$interest', '$new_date', '$currAccIBAN', '$loan_type')");

    mysqli_query($conn,$insertCreditQuery);

    $new_amount = $currAccAmount + $amount;
    $currAccUPDATE = 
        "UPDATE bank_account
        SET Amount = '$new_amount'
        WHERE IBAN = '$currAccIBAN'";

      mysqli_query($conn, $currAccUPDATE);
  }

  //Pay button
  if(isset($_GET['id'])){

    $currAccCreditInfoQuery = mysqli_query($conn, "SELECT credit.*,
                        credit_type.Type AS Credit_Type_Name
                        FROM credit 
                        INNER JOIN credit_type 
                        ON credit.Credit_Type_ID = credit_type.ID  
                        WHERE credit.Bank_Account_IBAN = '$currAccIBAN'");

    $currAccCreditInfo = mysqli_fetch_assoc($currAccCreditInfoQuery);

    $loan = $currAccCreditInfo['Amount'];
    $interest = $currAccCreditInfo['Interest'];

    switch($interest) {
      case 1:
          $months = 3;
        break;
      case 1.5:
          $months = 6;
        break;
      case 3:
          $months = 12;
        break;
      case 5:
          $months = 24;
        break;
      case 7.5:
          $months = 36;
        break;
      case 10:
          $months = 48;
        break;
    }

    $price_month = $loan / $months;

    $newAmount = $loan - $price_month;

    $creditUpdateQuery = 
        "UPDATE credit 
        SET Amount = '$newAmount'
        WHERE Bank_Account_IBAN = '$currAccIBAN'";

    mysqli_query($conn,$creditUpdateQuery);
  }

?>