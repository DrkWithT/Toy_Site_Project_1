<?php

/**
 * user.php
 * Services a generic user's home page.
 * Derek Tan
 * TODO: See line 35!
 */

require "./util.php";

/* Shared Var (across PHP blocks) */
$basic_data = NULL;

/* Helper Functions */
/**
 * Given a unique session ID cookie value, this function fetches basic user data: username and profile text.
 * @param mysqli &$db_connection
 * @param string $ssnid_cookie The session identifier.
 * @return array An associative array storing username and profile text.
 */
function fetchUserData(&$db_connection, $ssnid_cookie)
{
  $result = [
    "uname" => NULL,
    "uprofile" => NULL
  ]; // assoc array with named data: uname and udesc

  $usr_query_result = NULL; // for user data by username from query 1 within query 2
  $temp_usr_name = NULL;
  $temp_usr_desc = NULL;

  // 1st query (inside)
  $temp_usr_name = Util\matchSessionID($db_connection, $ssnid_cookie);

  // 2nd query
  $usr_query_result = $db_connection->query("SELECT * FROM users WHERE username='" . $temp_usr_name . "'");

  if ($usr_query_result != FALSE && $usr_query_result != NULL) {
    $row2 = $usr_query_result->fetch_assoc();

    if ($row2 != NULL) {
      $temp_usr_desc = $row2['userdesc'];
    } else {
      $temp_usr_desc = "A user.";
    }
  }

  // set result data (NULL by default on any error!)
  $result['uname'] = $temp_usr_name;
  $result['uprofile'] = $temp_usr_desc;

  return $result;
}

$db_con = new mysqli(Util\DB_HOST_STR, "HelperUser1", "ZA4b_3c7D?", Util\DB_NAME);  // connect to DB first

/* Postback */
if (!isset($_COOKIE['ssnID'])) {
  Util\redirectToPage(Util\SERVER_HOST_STR, ""); // redirect all visitors to homepage
} else if (strcmp($_COOKIE['ssnID'], "none") == 0) {
  Util\redirectToPage(Util\SERVER_HOST_STR, "");
} else {
  $basic_data = fetchUserData($db_con, $_COOKIE['ssnID']);
}

$db_con->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="./public/css/index.css" rel="stylesheet">
  <link href="./public/css/forms.css" rel="stylesheet">
  <title>A Poet's Place - User</title>
</head>

<body>
  <!-- Header and Nav -->
  <header>
    <h1 id="site-title">A Poet's Place</h1>
    <nav>
      <a class="nav-link" href="/poempanel.php">Manage</a>
      <a class="nav-link" href="/works.php">Read</a>
      <a class="nav-link" href="/logout.php">Logout</a>
    </nav>
  </header>
  <main id="scrollable">
    <!-- Info -->
    <section class="description-section">
      <div class="side-img-box">
        <div>
          <!-- Dynamic Username Heading -->
          <h3 class="section-heading">
            Welcome,&nbsp;
            <?php
            if (isset($basic_data['uname'])) {
              echo $basic_data['uname'];
            } else {
              echo "Anonymous";
            }
            ?>
          </h3>
          <p>
            Welcome back to your user homepage. Here, you can go to user-only pages!
            Deleting one of your poems is <em>irreversible!</em> Posting a new poem will upload a new poem directly, but trying to post onto an existing poem by you will fail. (Work in progress.)
          </p>
          <!-- Dynamic Profile (from DB result) -->
          <h3 class="section-heading">Profile</h3>
          <p>
            <?php
            if (isset($basic_data['uprofile'])) {
              echo $basic_data['uprofile'];
            } else {
              echo "<strong>Could not load profile.</strong>";
            }
            ?>
          </p>
        </div>
        <div>
          <img class="side-img" alt="bookshelf image" src="./public/img/noble_bookshelf_flickr.png">
        </div>
      </div>
    </section>
  </main>
</body>