<?php
/**
 * login.php
 * Services login for users.
 * Derek Tan
 */

/* Imports */
use function Util\redirectToPage;

// redirect logged in users to their pages
if (isset($_COOKIE['sessionID']))
{
  if ($_COOKIE['sessionID'] === "testonly") // TODO: change dummy session check!
    redirectToPage("user.php"); // redirect all logged in users to their own page
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
        Before entering your login information, please check that Caps Lock is not on.
      </p>
    </section>
    <!-- Login Form -->
    <section class="description-section">
      <div class="side-img-box">
        <div>
          <h3 class="section-heading">Log In</h3>
          <form id="register-form" class="page-form" method="POST" action="/gateway.php">
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
          <p id="form-msg" class="hidden">(Text)</p>
        </div>
        <div>
          <img class="side-img" src="./public/img/noble_bookshelf_flickr.png">
        </div>
      </div>
    </section>
  </main>
  <!-- JS -->
  <!-- <script src="public/js/check_form.js"></script> -->
</body>

</html>