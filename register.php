<?php
/**
 * register.php
 * Services registration for users.
 * Derek Tan
 */

/* Imports */
use function Util\redirectToPage;

if (isset($_COOKIE['sessionID'])) {
  if ($_COOKIE['sessionID'] === "testonly") // TODO: change dummy session check!
    redirectToPage("user.php"); // redirect all logged in users to their own page
}

// TODO: add support for session ID cookie and mySQL to check user registration attempts!
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
    <!-- Register Form: TODO: enable submit-btn AFTER fixing gateway to acccept signups! -->
    <section class="description-section">
      <h3 class="section-heading">Register</h3>
      <form id="register-form" class="page-form" method="POST" action="/gateway.php">
        <label class="form-label" for="username-field">Setup Username</label>
        <input id="username-field" class="form-field" name="username" type="text" minlength="8" maxlength="32" required>
        <label class="form-label" for="password-field">Setup Password</label>
        <input id="password-field" class="form-field" name="psword1" type="text" minlength="10" maxlength="48" required>
        <label class="form-label" for="pwconfirm-field">Confirm Password</label>
        <input id="pwconfirm-field" class="form-field" name="psword2" type="text" minlength="10" maxlength="48" required>
        <input id="submit-btn" type="submit" value="Submit" disabled>
      </form>
    </section>
  </main>
  <!-- JS -->
  <script src="public/js/validate_signup.js"></script>
</body>
</html>