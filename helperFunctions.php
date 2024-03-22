<?php 
function CreateIBAN() {
    $IBAN = "BG";
    for ($i = 0; $i < 20; $i++) {
        $IBAN .= rand(0, 9);
    }
    return $IBAN;
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
  
        $currAccUPDATE = 
          "UPDATE bank_account 
          SET Amount = '$currAccAmount'
          WHERE IBAN = '$currAccIBAN'";
  
        $recAccUPDATE = 
          "UPDATE bank_account 
          SET Amount = '$recAccAmount'
          WHERE IBAN = '$recAccIBAN'";
  
        mysqli_query($conn, $transaction);
        mysqli_query($conn, $currAccUPDATE);
        mysqli_query($conn, $recAccUPDATE);
        
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
}
?>
