<?php
/**
 * login.php
 * Services login for users.
 * Derek Tan
 */

/* Imports */
use Util;

/**
 * A helper function for checking a username with a password before any further action.
 * @param mysqli $db_con A reference to a SQL connection object.
 * @param string $uname A pre-sanitized username string.
 * @param string $pword A pre-sanitized password string.
 * @return int `0` on success, `1` on SQL connection failure, `2` on login failure.
 */
function checkLogin(&$db_con, $uname, $pword) {
  $status = 0; // Assume success until otherwise!

  $phash = NULL;
  $query_result = NULL;
  $query_row = NULL;
  
  // Connect with mySQLi credentials for connection and check for success.
  if (!$db_con->connect_error) {
    $phash = password_hash($pword, PASSWORD_BCRYPT);

    $query_result = $db_con->query("SELECT passhash FROM Users WHERE username = '" . $uname . "'");
  } else {
    $status = 1; // when connect error code is set, it will not be overwritten!
  }

  // Get query row only if connection is okay.
  if ($status == 0 && $query_result !== FALSE) {
    $query_row = $query_result->fetch_assoc();
  } else if ($status != 1) {
    $status = 2;
  }

  // Check for failing case of unmatching password hash.
  if ($status == 0 && $phash != NULL && $query_row != NULL) {
    if ($phash != $query_row['passhash']) {
      $status = 2;
    }
  } else if ($status != 1) {
    $status = 2;
  }

  return $status;
}

/* Postback */
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $db_con = new mysqli(Util\DB_HOST_STR, "HelperUser1", "ZA4b_3c7D?", Util\DB_NAME);  // connect to DB first

  // check if user is already logged on for a redirect home
  if (isset($_COOKIE['ssnID'])) {
    if (Util\matchSessionID($db_con, $_COOKIE['ssnID']) != "none") {
      Util\redirectToPage(Util\SERVER_HOST_STR, "user.php");
    }
  }

  $raw_username = $POST['username'];
  $raw_password = $POST['password'];

  $clean_username = $db_con->real_escape_string(Util\sanitizeText($raw_username));
  $clean_password = $db_con->real_escape_string(Util\sanitizeText($raw_password));

  // authenticate user based on their login info
  $login_status = checkLogin($db_con, $clean_username, $clean_password);
  $recorded_ssn = FALSE; 

  if ($login_status == 0) {
    $recorded_ssn = Util\createSession($db_con, $clean_username, uniqid(Util\UNIQID_PREFIX));
  }
  
  $db_con->close();

  // log error message to client
  switch ($login_status) {
    case 1:
      setcookie("ssnID", "none");
      echo "Unable to auth!";
      break;
    case 2:
      setcookie("ssnID", "none");
      echo "Invalid login data!";
      break;
    default:
      Util\redirectToPage(Util\SERVER_HOST_STR, "user.php");
      break;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="./public/css/index.css" rel="stylesheet">
  <link href="./public/css/forms.css" rel="stylesheet">
  <title>A Poet's Place - Login</title>
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
      <h3 class="section-heading">Tips</h3>
      <p>
        Before entering your login information, ensure that Caps Lock is not on.
      </p>
    </section>
    <!-- Login Form -->
    <section class="description-section">
      <div class="side-img-box">
        <div>
          <h3 class="section-heading">Log In</h3>
          <form id="login-form" class="page-form" method="POST" action="/login.php">
            <div class="form-item">
              <label class="form-label" for="username-field">Username</label>
              <input id="username-field" class="form-field" name="username" type="text" maxlength="32" minlength="8" required>
            </div>
            <div class="form-item">
              <label class="form-label" for="password-field">Password</label>
              <input id="password-field" class="form-field" name="password" type="password" maxlength="48" minlength="10" required>
            </div>
            <div class="form-item">
              <input id="submit-btn" type="submit" value="Log In">
            </div>
          </form>
          <p id="form-msg">Enter login.</p>
        </div>
        <div>
          <img class="side-img" src="./public/img/noble_bookshelf_flickr.png">
        </div>
      </div>
    </section>
  </main>
  <!-- JS -->
  <!-- none for now! -->
</body>

</html>