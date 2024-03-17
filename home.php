<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bank Homepage</title>
    <link rel="stylesheet" href="Style/styles.css" />
  </head>
  <body>
    <div class="container">
      <header>
        <h1>Welcome to Our Bank</h1>
        <nav>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Credits</a></li>
            <li><a href="#">Transactions</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="LOGIN.php">Logout</a></li>
          </ul>
        </nav>
      </header>
      <main>
        <section class="make-transaction">
          <h2>Make a Transaction</h2>
          <form action="make_transaction.php" method="post">
            <label for="amount">Amount:</label>
            <input type="text" id="amount" name="amount" required />
            <label for="recipient">Recipient:</label>
            <input type="text" id="recipient" name="recipient" required />
            <button type="submit">Submit</button>
          </form>
        </section>
        <section class="transactions">
          <h2>Recent Transactions</h2>
          <table>
            <thead>
              <tr>
                <th>Date</th>
                <th>Transaction Type</th>
                <th>Sender</th>
                <th>Receiver</th>
                <th>Amount</th>
              </tr>
            </thead>
          </table>
        </section>
      </main>
      <footer>
        <p>&copy; <?php echo date("Y"); ?> BankName. All rights reserved.</p>
      </footer>
    </div>
  </body>
</html>
