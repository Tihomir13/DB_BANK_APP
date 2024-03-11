<?php
  include("database.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BankApp</title>
    <link rel="stylesheet" href="table.css" />
    <link rel="stylesheet" href="footer.css" />

    <script>
       document.getElementById("Formsort").addEventListener("submit", function(event) {
         event.preventDefault();
       });
    </script>

  </head>
  <body>
    <header> </header>
    <main>
      <div class="container">
        <div
          class="left-main-form"
          style="
            padding: 0px 100px;
            border-radius: 30px;
            background-color: rgb(191, 191, 191);
          "
        >
          <form
            action="index.php"
            method="post"
            style="display: flex; flex-direction: column; gap: 5rem"
          >
            <button name="button1" value="sort">sort by Име</button>
            <button name="button2" value="Име">Име</button>
            <button name="button3" value="Име">Име</button>
            <button name="button4" value="Име">Име</button>
          </form>
        </div>
        <div class="fixed-div">
          <table>
            <thead>
              <tr>
                <th>Name<form  action="index.php"
                method="post"><button name="sorting" id="Formsort"><img src="pictures/sort.png"></button></form></th>
                <th>EGN</th>
                <th>Address</th>
                <th>Phone Number</th>
                <th>Email</th>
              </tr>
            </thead>
            <tbody> 
              <tr>
              <tr>
                <?php
                $sorted = true;
                      if (isset($_POST["sorting"]) && $sorted === true) {
                        $result = mysqli_query($conn, "SELECT * FROM client ORDER BY Name DESC");
                        while($row = mysqli_fetch_assoc($result)){
                          ?>
                          <td><?php echo $row ['Name'];?></td>
                          <td><?php echo $row ['EGN'];?></td>
                          <td><?php echo $row ['Address'];?></td>
                          <td><?php echo $row ['Phone_number'];?></td>
                          <td><?php echo $row ['Email'];?></td>
                          </tr>
                          <?php
                          $sorted = false;
                        }
                      }
                      else if (isset($_POST["sorting"]) && $sorted === false) {
                        $result = mysqli_query($conn, "SELECT * FROM client ORDER BY Name DESC");
                        while($row = mysqli_fetch_assoc($result)){
                          ?>
                          <td><?php echo $row ['Name'];?></td>
                          <td><?php echo $row ['EGN'];?></td>
                          <td><?php echo $row ['Address'];?></td>
                          <td><?php echo $row ['Phone_number'];?></td>
                          <td><?php echo $row ['Email'];?></td>
                          </tr>
                          <?php
                          $sorted = true;
                        }
                      }
                    // else echo"Error"
                    else if(mysqli_query($conn, "SELECT * FROM client")) {
                      $result = mysqli_query($conn, "SELECT * FROM client");
                      while($row = mysqli_fetch_assoc($result)){
                        ?>
                        <td><?php echo $row ['Name'];?></td>
                        <td><?php echo $row ['EGN'];?></td>
                        <td><?php echo $row ['Address'];?></td>
                        <td><?php echo $row ['Phone_number'];?></td>
                        <td><?php echo $row ['Email'];?></td>
                        </tr>
                        <?php
                      }
                    }
                    else echo"Error";
                  ?>
            </tbody>
          </table>
        </div>
        <div
          class="right-main-form"
          style="
            padding: 0px 100px;
            border-radius: 30px;
            background-color: rgb(191, 191, 191);
          "
        >
          <form
            action=""
            method="post"
            style="display: flex; flex-direction: column; gap: 5rem"
          >
            <button name="button1" value="Име">Име</button>
            <button name="button2" value="Име">Име</button>
            <button name="button3" value="Име">Име</button>
            <button name="button4" value="Име">Име</button>
          </form>
        </div>
      </div>
    </main>

    <div class="textBoxes">
      <div id="left">
        <form action="ClientChanges.php" method="post" id="form-Changer">
          <div style="gap: 20px; display: flex; flex-direction: column">
            <input type="text" class="textBox-Changers" placeholder="Name" required name="Name-Client"/>
            <input type="text" class="textBox-Changers" placeholder="EGN" required name="EGN-Client"/>
            <input type="text" class="textBox-Changers" placeholder="Address" required name="Address-Client"/>
            <input
              type="text"
              class="textBox-Changers"
              placeholder="Phone Number"
              required
              name="Phone-Client"
            />
            <input type="email" class="textBox-Changers" placeholder="Email" required name="Email-Client"/>
          </div>
          <div
            style="
              gap: 20px;
              display: flex;
              flex-direction: column;
              justify-content: center;
            "
          >
            <input type="submit" value="Add" class="Button-Changers" name="add-Client"/>
            <input type="submit" value="Update" class="Button-Changers" name="update-Client"/>
            <input type="submit" value="Delete" class="Button-Changers" name="delete-Client"/>
          </div>
        </form>
      </div>
      <div id="right">
        <form
          action=""
          method="post"
          style="display: flex; flex-direction: column; align-items: center"
        >
          <div class="button-row">
            <input type="submit" value="table1" class="table-Button" />
            <input type="submit" value="table2" class="table-Button" />
            <input type="submit" value="table3" class="table-Button" />
            <input type="submit" value="table4" class="table-Button" />
            <input type="submit" value="table5" class="table-Button" />
            <input type="submit" value="table6" class="table-Button" />
          </div>
          <div class="button-row">
            <input type="submit" value="table7" class="table-Button" />
            <input type="submit" value="table8" class="table-Button" />
            <input type="submit" value="table9" class="table-Button" />
            <input type="submit" value="table10" class="table-Button" />
            <input type="submit" value="table11" class="table-Button" />
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
