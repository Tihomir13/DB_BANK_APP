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
  </head>
  <body>
    <header> </header>
    <!-- SELECT `COLUMN_NAME` 
    FROM `INFORMATION_SCHEMA`.`COLUMNS` 
    WHERE `TABLE_SCHEMA`='yourdatabasename' 
        AND `TABLE_NAME`='yourtablename'; -->
    <main>
      <div class="container">
        <form action="" method="post">
          <input type="submit" value="Име" />
          <input type="submit" value="Име" />
          <input type="submit" value="Име" />
          <input type="submit" value="Име" />
        </form>
        <div class="fixed-div">
          <table>
            <thead>
              <tr>
                <?php
                    if (mysqli_query($conn, "SHOW COLUMNS FROM client")) {
                      $result = mysqli_query($conn, "SHOW COLUMNS FROM client");
                      while($row = mysqli_fetch_assoc($result)){
                        ?>
                        <td><?php echo key($row);?></td>
                        </tr>
                        <?php
                      }
                    }
                  ?>
              </tr>
            </thead>
            <tbody> </tbody>
          </table>
        </div>
        <form action="" method="post">
          <input type="submit" value="Име" />
          <input type="submit" value="Име" />
          <input type="submit" value="Име" />
          <input type="submit" value="Име" />
        </form>
      </div>
    </main>
    <aside> </aside>
  </body>
</html>
