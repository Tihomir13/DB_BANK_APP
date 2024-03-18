<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Credits</title>
    <link rel="stylesheet" href="Style\styles.css" />
    <!-- Включете вашия CSS файл тук -->
  </head>
  <body>
    <header>
      <h1>Credits</h1>
      <nav>
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="Transactions.php">Transactions</a></li>
          <li><a href="profile.html">Profile</a></li>
          <li><a href="Login.php">Logout</a></li>
        </ul>
      </nav>
    </header>

    <main>
      <section class="credit-form">
        <h2>Apply for Credit</h2>
        <form action="process_credit_application.php" method="post">
          <div>
            <label for="amount">Amount:</label>
            <input type="text" id="amount" name="amount" required />
          </div>
          <div>
            <label for="duration">Duration (months):</label>
            <select id="duration">
              <option value="option1">3 months</option>
              <option value="option2">6 months</option>
              <option value="option3">1 year</option>
              <option value="option4">2 year</option>
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
    </main>

    <footer>
      <p>&copy; 2024 Your Bank. All rights reserved.</p>
    </footer>
  </body>
</html>

<script>
  function InterestUpdate() {
    const rateElement = document.getElementById("interest_rate");
    const durationInput = document.getElementById("duration");
    rateElement.textContent = "1%";

    durationInput.addEventListener("change", function () {
      let durationInputVal = durationInput.selectedOptions[0].value;
      switch (durationInputVal) {
        case "option1":
          rateElement.textContent = "1%";
          break;
        case "option2":
          rateElement.textContent = "1.5%";
          break;
        case "option3":
          rateElement.textContent = "3%";
          break;
        case "option4":
          rateElement.textContent = "5%";
          break;
        default:
          return;
          break;
      }
    });
  }
  InterestUpdate();
</script>
