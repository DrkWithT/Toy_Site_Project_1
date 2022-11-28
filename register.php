<?php
/**
 * register.php
 * Services registration for users.
 * Derek Tan
 */

require "./utils/util.php";

$signup_ok = NULL;

/* Helper Functions */
/**
 * Attempts to create an incoming user's entry in DB within table "Users". Inputs SHOULD be sanitized.
 * @param mysqli &$db_connection A mySQL conenction reference. 
 * @param string $uname Username string.
 * @param string $pword_original The real password string.
 * @param string $pword_confirm A repeat of the password string.
 * @return bool TRUE on success.
 */
function tryRegister(&$db_connection, $uname, $pword_original, $pword_confirm)
{
  $clean_username = $db_connection->real_escape_string(Util\sanitizeText($uname));
  $clean_password1 = $db_connection->real_escape_string(Util\sanitizeText($pword_original));
  $clean_password2 = $db_connection->real_escape_string(Util\sanitizeText($pword_confirm));

  $status = FALSE;

  // Check for username length and new password match
  if (strlen($uname) < 6 || $clean_password1 !== $clean_password2) {
    return $status;
  }

  // If connection is ok, do SQL operation
  if ($db_connection->connect_errno == 0) {
    $pshash = password_hash($clean_password1, PASSWORD_BCRYPT); // Securely hash password by BCrypt

    $userdesc = "A fellow user.";

    // Attempt to create a new account entry in DB
    $status = $db_connection->query("INSERT INTO users VALUES ('" . $clean_username . "', '" . $pshash . "', '" . $userdesc . "')");
  }

  return $status;
}

/* Postback */
if ($_SERVER['REQUEST_METHOD'] === "POST") {
  $db_con = new mysqli(Util\DB_HOST_STR, "HelperUser1", "ZA4b_3c7D?", Util\DB_NAME);  // connect to DB first

  // get form data
  $raw_username = $_POST['username'];
  $raw_pword1 = $_POST['psword1'];
  $raw_pword2 = $_POST['psword2'];

  // attempt to create a new account
  $signup_ok = tryRegister($db_con, $raw_username, $raw_pword1, $raw_pword2);

  // Close mySQL connection
  $db_con->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- CSS -->
  <link href="./public/css/index.css" rel="stylesheet">
  <link href="./public/css/forms.css" rel="stylesheet">
  <!-- Icon -->
  <link rel="shortcut icon" href="./public/img/favicon.ico" type="image/x-icon">
  <title>A Poet's Place - Register</title>
</head>

<body>
  <!-- Header and Nav -->
  <header>
    <h1 id="site-title">A Poet's Place</h1>
    <nav>
      <a class="nav-link" href="/homepage.html">Home</a>
    </nav>
  </header>
  <main id="scrollable">
    <!-- Info -->
    <section class="description-section">
      <h3 class="section-heading">Before You Sign Up&colon;</h3>
      <p>
        Make a good password containing a mix of lowercase, uppercase, digits, and punctuation. Also, do <strong>NOT</strong> expose personal information in your username, password, or posts.
      </p>
    </section>
    <!-- Register Form: TODO: enable form AFTER fixing Util funcs for registration. See "util.php"! -->
    <section class="description-section">
      <div class="side-img-box">
        <div>
          <h3 class="section-heading">Register</h3>
          <form id="register-form" class="page-form" method="POST" action="/register.php">
            <label class="form-label" for="username-field">Setup Username</label>
            <input id="username-field" class="form-field" name="username" type="text" minlength="6" maxlength="36" required>
            <label class="form-label" for="password-field">Setup Password</label>
            <input id="password-field" class="form-field" name="psword1" type="password" minlength="12" maxlength="48" required>
            <label class="form-label" for="pwconfirm-field">Confirm Password</label>
            <input id="pwconfirm-field" class="form-field" name="psword2" type="password" minlength="12" maxlength="48" required>
            <input id="submit-btn" type="submit" value="Submit">
          </form>
          <p id="form-msg">Enter inputs.</p>
        </div>
        <div>
          <img class="side-img" alt="bookshelf image" src="./public/img/noble_bookshelf_flickr.png">
        </div>
      </div>
      <?php
      if ($signup_ok) {
        echo "<div><a class=\"nav-link\" href=\"/login.php\">Login!</a></div>";
      } else if ($signup_ok === FALSE) {
        echo "<div><p>Invalid username or password.</p><a class=\"nav-link\" href=\"/homepage.html\">Home</a></div>";
      } else {
        echo "<p>Follow the tips above.</p>";
      }
      ?>
    </section>
  </main>
  <!-- JS -->
  <script src="./public/js/validate_signup.js"></script>
</body>

</html>