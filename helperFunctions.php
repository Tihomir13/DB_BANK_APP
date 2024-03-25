<?php 
function CreateIBAN() {
    $IBAN = "BG";
    for ($i = 0; $i < 20; $i++) {
        $IBAN .= rand(0, 9);
    }
    return $IBAN;
}

function updateAccAmount($conn, $newAmount, $currAccIBAN) {
  $AccUPDATE = 
  "UPDATE bank_account 
  SET Amount = '$newAmount'
  WHERE IBAN = '$currAccIBAN'";

  mysqli_query($conn, $AccUPDATE);
}

function creatingBankAccount($Client_EGN, $conn){
    $IBAN = CreateIBAN();
    $Interest = 0.00;

    // 1 - Active
    // 2 - Inactive
    // 3 - Pending
    $Account_Status_ID = 1;

    // 1 - BGN
    // 2 - EUR
    // 3 - USD
    $Currency_ID = 1;
    $Amount = 0;

    $insertBankAccount = "INSERT INTO bank_account (IBAN, Interest, Account_Status_ID, Client_EGN, Currency_ID, Amount)
            VALUES ('$IBAN', '$Interest','$Account_Status_ID', '$Client_EGN', '$Currency_ID', '$Amount')";

    mysqli_query($conn, $insertBankAccount);      
}

function SetUserData($userData) {
    $_SESSION['username'] = $userData['username'];
    $_SESSION['name'] = $userData['Name'];
    $_SESSION['email'] = $userData['Email'];
    $_SESSION['egn'] = $userData['EGN'];
}

function processTransfer($conn, $currAccIBAN, $currAccAmount) {
    if(isset($_POST["transferButton"])){
        $amountTransfer = $_POST['amount'];
        $recipientIBAN = $_POST['recipient'];
        
        $recAccQuery = mysqli_query($conn, "SELECT * FROM bank_account WHERE IBAN = '$recipientIBAN'");
        $recipientAccInfo = mysqli_fetch_assoc($recAccQuery);
        
        $recAccIBAN = $recipientAccInfo['IBAN'];
        $recAccAmount = $recipientAccInfo['Amount'];
  
        // Проверка за наличие на IBAN-а който е въведен
        if ($recAccQuery && mysqli_num_rows($recAccQuery) != 1){
          echo '
            <script>
              alert("Несъществуващ IBAN!");
            </script>';
          exit();
        }
        
        // Проверка за наличие на парични средства
        if($amountTransfer > $currAccAmount) {
          echo '
            <script>
              alert("Недостатъчни средства!");
            </script>';
          exit();
        }
  
        $currAccAmount -= $amountTransfer;
        $recAccAmount += $amountTransfer;
  
        $randomQuery = "SELECT EGN, Name FROM employee WHERE Position_ID = 2 ORDER BY RAND() LIMIT 1";
        $randomEmployee = mysqli_fetch_assoc(mysqli_query($conn, $randomQuery));
        $EmployeeName = $randomEmployee['EGN'];
  
        $transaction = "INSERT INTO transaction (Amount, Trans_Type_ID, S_Bank_Account_IBAN, R_Bank_Account_IBAN, Employee_EGN)
        VALUES ('$amountTransfer', 3, '$currAccIBAN', '$recAccIBAN', '$EmployeeName')";

        updateAccAmount($conn, $currAccAmount, $currAccIBAN);
        updateAccAmount($conn, $recAccAmount, $recAccIBAN);

        mysqli_query($conn, $transaction);
        
        echo '
        <script> 
          document.getElementsByName("transferButton").addEventListener("click", function() {
          location.reload();
          });
        </script>';
      }
}

function applyCredit($conn, $currAccIBAN, $currAccAmount) {
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
    
    $amountPerInstallment = round($loan / $months, 2);

    $insertCreditQuery = ("INSERT INTO credit (Total_amount, Amount, Interest, Remaining_amount, Amount_installment, Remaining_installments, Repayment_Period, Bank_Account_IBAN, Credit_Type_ID)
    VALUES ('$loan', '$amount', '$interest', '$loan', '$amountPerInstallment', '$months','$new_date','$currAccIBAN', '$loan_type')");

    mysqli_query($conn, $insertCreditQuery);

    // Добавяне на пари в акаунта
    $currAccAmount += $amount;

    $currAccUPDATE = 
        "UPDATE bank_account
        SET Amount = '$currAccAmount'
        WHERE IBAN = '$currAccIBAN'";

      mysqli_query($conn, $currAccUPDATE);
      exit();
  }
}

function updateCreditInfo($conn, $currAccIBAN, $currAccAmount) {
  // Извличане на информация за кредита
  $currAccCreditInfoQuery = mysqli_query($conn, "SELECT credit.*, credit_type.Type AS Credit_Type_Name
                      FROM credit 
                      INNER JOIN credit_type 
                      ON credit.Credit_Type_ID = credit_type.ID  
                      WHERE credit.Bank_Account_IBAN = '$currAccIBAN'");

  $currAccCreditInfo = mysqli_fetch_assoc($currAccCreditInfoQuery);

  // Извличане на стойности от информацията за кредита
  $remaining_amount = $currAccCreditInfo['Remaining_amount']; // Оставащ кредит
  $interest = $currAccCreditInfo['Interest'];
  $remaining_installments = $currAccCreditInfo['Remaining_installments']; // Оставащи месеци/вноски
  $price_month = $currAccCreditInfo['Amount_installment']; 

  $remaining_amount -= $price_month;
  $remaining_installments -= 1;

  // Актуализация на стойностите в базата данни
  if ($remaining_installments == 0) {
      $creditUpdateQuery = "DELETE FROM credit WHERE Bank_Account_IBAN = '$currAccIBAN'";
  } else {
      $creditUpdateQuery = "UPDATE credit 
                          SET Remaining_amount = '$remaining_amount',
                              Remaining_installments = '$remaining_installments'
                          WHERE Bank_Account_IBAN = '$currAccIBAN'";
  }

  $currAccAmount -= $price_month;
  updateAccAmount($conn, $currAccAmount, $currAccIBAN);
  mysqli_query($conn, $creditUpdateQuery);
  exit();
}

?>
