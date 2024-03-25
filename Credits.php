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
    <script defer src="./interest.js"></script>
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
        <div class="transaction-header-section" style="display: flex; justify-content: space-between">
          <h2>Apply for Credit 
          <h2 style="position:relative; right: 125px;">Amount: <?php echo "$currAccAmount $currAccCurrency";?></h2>
        </div>
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
                <th>Total repayment amount</th>
                <th>Total Amount Received by Client</th>
                <th>Interest (%)</th>
                <th>Remaining Amount</th>
                <th>Amount for an installment</th>
                <th>Remaining installments</th>
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
                            <td><?php echo $row ['Total_amount'];?></td>
                            <td><?php echo $row ['Amount'];?></td>
                            <td><?php echo $row ['Interest'];?></td>
                            <td><?php echo $row ['Remaining_amount'];?></td>
                            <td><?php echo $row ['Amount_installment'];?></td>
                            <td><?php echo $row ['Remaining_installments'];?></td>
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
  </body>
</html>

<?php 
  applyCredit($conn, $currAccIBAN, $currAccAmount);
  updateCreditInfo($conn, $currAccIBAN, $currAccAmount);
?>