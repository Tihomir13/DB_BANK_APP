<?php
include("User_Acc_Info.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <script src="helperJS.js"></script>
    <?php 
        // include("Bootstrap.php");
    ?>
    <style>
        button {
            background-color: #EA4C89;
            border-radius: 8px;
            border-style: none;
            box-sizing: border-box;
            color: #FFFFFF;
            cursor: pointer;
            display: inline-block;
            font-family: "Haas Grot Text R Web", "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 14px;
            font-weight: 500;
            height: 40px;
            line-height: 20px;
            list-style: none;
            margin: 0;
            outline: none;
            padding: 10px 16px;
            position: relative;
            text-align: center;
            text-decoration: none;
            transition: color 100ms;
            vertical-align: baseline;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
        }

        .submit:hover,
        .submit:focus {
        background-color: darkblue;
        }

        .delete:hover,
        .delete:focus {
        background-color: darkred;
        }

        .submit {
            background-color: blue;
        }
        .delete {
            background-color: red;
        }
    </style>
    <link rel="stylesheet" href="Style\styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Welcome, <?php echo $name?></h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="Credits.php">Credits</a></li>
                    <li><a href="Transactions.php">Transactions</a></li>
                    <li><a href="#"><?php echo (isset($currAccAmount)) ? 'Profile' : 'Clients'; ?></a></li>
                    <li><a href="LOGIN.php">Logout</a></li>
                </ul>
            </nav>
        </header>
        <main>
        <?php if(isset($currAccAmount)) { ?>
            <section class="profile-info">
                <h2>User Information</h2> 
                <form action="#" method="post" style="display: flex; gap: 30px">
                <div style="display: inline-flex; flex-direction: column;">
                    <input style="margin-top: 8px" type="text" required name="newName" value="<?php echo $name ?>"/>
                    <input style="margin-top: 8px" type="email" required name="newEmail" value="<?php echo $email ?>"/>
                    <input style="margin-top: 8px" type="text" required name="newAddress" value="<?php echo $address ?>"/>
                    <input style="margin-top: 8px" type="tel" pattern="[0-9]{10}" required name="newPhone_number" value="<?php echo $phone_number ?>"/>
                </div>
                <div style="display: inline-flex; flex-direction: column; gap: 10px">
                    <button class="submit" style="margin-top: 8px" type="submit" name="editUserInfo">Save</button>
                    <button class="delete" type="submit" name="deleteUser">Delete Account</button>
                </div>
                </form>
            </section>
        <?php } 
        else { ?>
        <section class="transactions">
            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>EGN</th>
                    <th>Address</th>
                    <th>Phone number</th>
                    <th>Email</th>
                    <th>username</th>
                    <th>password</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <?php 
                    $result = mysqli_query($conn, "SELECT * FROM client");
                    if($result) {
                        while($row = mysqli_fetch_assoc($result)){
                            ?>
                                <td><?php echo $row ['Name'];?></td>
                                <td><?php echo $row ['EGN'];?></td>
                                <td><?php echo $row ['Address'];?></td>
                                <td><?php echo $row ['Phone_number'];?></td>
                                <td><?php echo $row ['Email'];?></td>
                                <td><?php echo $row ['username'];?></td>
                                <td><?php echo $row ['password'];?></td>
                            </tr>
                        <?php
                        }
                    }
                            else echo"Error";
                    }
                    ?>
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
    if(isset($_POST["editUserInfo"])){

        $newName = $_POST["newName"];
        $newEmail = $_POST["newEmail"];
        $newAddress = $_POST["newAddress"];
        $newPhone_number = $_POST["newPhone_number"];

        $updateClientQuery = "UPDATE client
                            SET Name = '$newName',
                            Email = '$newEmail',
                            Address = '$newAddress',
                            Phone_number = '$newPhone_number'
                            WHERE EGN = '$egn'";
                                    
        $updateClient = mysqli_query($conn, $updateClientQuery);
        exit();
    }

    if(isset($_POST["deleteUser"])){

        
        $HasCreditQuery = ("SELECT * FROM credit WHERE Bank_Account_IBAN = '$currAccIBAN'");
        $result = mysqli_query($conn, $HasCreditQuery);
        
        if ($result && mysqli_num_rows($result) == 1){
            echo '
            <script>
            alert("You have to pay off your loan before you delete your Bank Account!");
            </script>';
            exit();
        };

        echo " <script>
            deleteVerify();
        </script>";

        $deleteBankAcc = "DELETE FROM bank_account WHERE IBAN = '$currAccIBAN'";
        $deleteUser = "DELETE FROM client WHERE EGN = '$egn'";
        
        $deleteBankAcc = mysqli_query($conn,$deleteBankAcc);
        $deleteClient = mysqli_query($conn,$deleteUser);

        header("Location: Login.php");
    }
?>
