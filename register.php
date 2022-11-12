<?php

/**
 * register.php
 * Services registration for users.
 * Derek Tan
 * TODO: Finish and integrate tryRegister function!
 */

/* Imports */
use Util;

/**
 * Attempts to create an incoming user's entry in DB within table "Users". Also tries to insert a session record into the DB.
 */
// function tryRegister($uname, $pword_original, $pword_confirm) {
//   $sanitized_uname = sanitizeText($uname, SANIT_HTML_ESC);
//   $sanitized_pword1 = sanitizeText($pword_original, SANIT_HTML_ESC);
//   $sanitized_pword2 = sanitizeText($pword_confirm, SANIT_HTML_ESC);

//   $result = "none";

//   $db_con = NULL;

//   if (strlen($uname) >= 6 && $sanitized_pword1 === $sanitized_pword2) {
//     // Connect with mySQLi credentials for connection and check for success...
//     $db_con = new mysqli(DB_HOST_STR, "HelperUser1", "ZA4b_3c7D?", DB_NAME);
//   }

//   // IF all is ok, do the SQL operation
//   if (!$db_con->connect_error) {
//     $pshash = password_hash($sanitized_pword1, PASSWORD_BCRYPT); // Securely encrypt password by BCrypt
//     $userdesc = "A fellow user.";

//     // Attempt to prepare SQL statement (check for SQL errors and pre-existing entry!).
//     $new_usr_statement = $db_con->prepare("INSERT INTO Users (username, passhash, userdesc) VALUE (?, ?, ?)");
//     $new_usr_statement->bind_param("sss", $sanitized_uname, $pshash, $userdesc);
//     $new_usr_statement->execute();

//     // Create user session if prior operation worked
//     if ($db_con->errno == 0) {
//       $ssn_id_temp = uniqid("A2cF4", TRUE); // make special ID string for "ssn_id" cookie
      
//       if ($db_con->query("INSERT INTO UserSsns (s_id, s_usr) VALUE ($ssn_id_temp, $sanitized_uname)") == TRUE) {
//         $result = $ssn_id_temp;
//       }
//     } else {
//       echo "Signup Failed.";
//     }
    
//     // Close mySQL connection
//     $db_con->close();
//   }

//   return $result; // TODO: Create a cookie from this string!
// }

if ($_SERVER['REQUEST_METHOD'] === "POST") {
  $username = $_POST['username'];
  $pword1 = $_POST['psword1'];
  $pword2 = $_POST['psword1'];

  // TODO: add cookie-based auth feature WITH mySQL to check user registration attempts! See namespace Util.
  // TODO: implement and use Util\tryRegister as main registration function! See namespace Util.
  
  // if the registration worked, assign session ID to track user
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
  <title>A Poet's Place - Register</title>
</head>

<body>
  <!-- Header and Nav -->
  <header>
    <h1 id="site-title">A Poet's Place</h1>
    <nav>
      <!-- TODO: replace href with /landing.php -->
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
          <!-- <form id="register-form" class="page-form" method="POST" action="/register.php">
            <label class="form-label" for="username-field">Setup Username</label>
            <input id="username-field" class="form-field" name="username" type="text" minlength="6" maxlength="36" required>
            <label class="form-label" for="password-field">Setup Password</label>
            <input id="password-field" class="form-field" name="psword1" type="text" minlength="12" maxlength="48" required>
            <label class="form-label" for="pwconfirm-field">Confirm Password</label>
            <input id="pwconfirm-field" class="form-field" name="psword2" type="text" minlength="12" maxlength="48" required>
            <input id="submit-btn" type="submit" value="Submit" disabled>
          </form> -->
        </div>
        <div>
          <img class="side-img" src="./public/img/noble_bookshelf_flickr.png">
        </div>
      </div>
    </section>
  </main>
  <!-- JS -->
  <script src="public/js/validate_signup.js"></script>
</body>

</html>