<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="./public/css/index.css" rel="stylesheet">
  <link href="./public/css/forms.css" rel="stylesheet">
  <title>A Poet's Place - Logout</title>
</head>

<body>
  <header>
    <h1 id="site-title">A Poet's Place</h1>
    <nav>
      <a class="nav-link" href="/homepage.html">Home</a>
    </nav>
  </header>
  <main id="scrollable">
    <section class="description-section">
      <div class="side-img-box">
        <div>
          <h3 class="section-heading">Log In</h3>
          <p>
            Enter &quot;THE END&quot; to confirm logout.
          </p>
          <form id="login-form" class="page-form" method="POST" action="/logout.php">
            <div class="form-item">
              <label class="form-label" for="confirm-field">Confirm</label>
              <input id="confirm-field" class="form-field" name="quitword" type="text" maxlength="12" required>
            </div>
            <div class="form-item">
              <input id="submit-btn" type="submit" value="Log Out">
            </div>
          </form>
        </div>
        <div>
          <img class="side-img" alt="bookshelf image" src="./public/img/noble_bookshelf_flickr.png">
        </div>
      </div>
    </section>
    <?php
    /**
     * logout.php
     * Services logout for users.
     * Derek Tan
     */

    require "./utils/util.php";

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      $db_con = new mysqli(Util\DB_HOST_STR, "HelperUser1", "ZA4b_3c7D?", Util\DB_NAME);  // connect to DB first

      $ssn_uname = Util\matchSessionID($db_con, $_COOKIE['ssnID']);

      Util\destroySession($db_con, $ssn_uname);

      $db_con->close();

      Util\redirectToPage(Util\SERVER_HOST_STR, "");
    }
    ?>
  </main>
</body>

</html>