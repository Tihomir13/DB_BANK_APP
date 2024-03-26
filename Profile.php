<?php
include("User_Acc_Info.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
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
                <form action="#" method="post" style="display: inline-flex; flex-direction: column;">
                    <input style="margin-top: 8px" type="text" required name="newName" value="<?php echo $name ?>"/>
                    <input style="margin-top: 8px" type="text" required name="newEmail" value="<?php echo $email ?>"/>
                    <input style="margin-top: 8px" type="text" required name="newAddress" value="<?php echo $address ?>"/>
                    <input style="margin-top: 8px" type="text" required name="newPhone_number" value="<?php echo $phone_number ?>"/></p>
                    <button type="submit" name="editUserInfo">Edit</button>
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
                                    
        $updateClient = mysqli_query($conn,$updateClientQuery);
    }
?>
