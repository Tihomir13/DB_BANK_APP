<?php 
  session_start();
  require('database.php');
  require('Helpers/helperFunctions.php');

  $username = $_SESSION['username'];
  $name = $_SESSION['name'];
  $email = $_SESSION['email'];
  $egn = $_SESSION['egn'];
  $address = $_SESSION['address'];
  $phone_number = $_SESSION['phone_number'];

  $Client = mysqli_query($conn, "SELECT * FROM client WHERE username = '$username'");

  if($Client && mysqli_num_rows($Client) == 1){
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
  }
?>