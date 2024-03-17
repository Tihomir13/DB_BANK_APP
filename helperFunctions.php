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

?>
