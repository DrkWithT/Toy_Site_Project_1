<?php
/**
 * user.php
 * Services a generic user's home page.
 * Derek Tan
 * TODO: See line 35!
 */

/* Imports */
use Util;

/* Shared Var (across PHP blocks) */
$basic_data = NULL;

/* Helper Functions */
/**
 * Given a unique session ID cookie value, this function fetches basic user data: username and profile text.
 * @param mysqli &$db_connection
 * @param string $ssnid_cookie The session identifier.
 * @return array An associative array storing username and profile text.
 */
function fetchUserData(&$db_connection, $ssnid_cookie) {
  $query_result = NULL;
  $result = [];

  if ($db_connection->connect_errno == 0) {
    $query_result = $db_connection->query("SELECT * FROM Ssns WHERE ssnid='" . $ssnid_cookie . "'");
  }

  if ($query_result != NULL) {
    $row = $query_result->fetch_assoc();

    if ($row != NULL) {
      $result['uname'] = $row['username'];
      $result['uprofile'] = $row['userdesc']; // TODO: change this field name based on real DB! 
    }
  }

  return $result;
}

$db_con = new mysqli(Util\DB_HOST_STR, "HelperUser1", "ZA4b_3c7D?", Util\DB_NAME);  // connect to DB first

if (!isset($_COOKIE['sessionID'])) {
  Util\redirectToPage(Util\SERVER_HOST_STR, ""); // redirect all visitors to homepage
} else if ($_COOKIE['sessionID'] == "none") {
  Util\redirectToPage(Util\SERVER_HOST_STR, "");
} else {
  $basic_data = fetchUserData($db_con, $_COOKIE['sessionID']);
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
  <title>A Poet's Place - User</title>
</head>

<body>
  <!-- Header and Nav -->
  <header>
    <h1 id="site-title">A Poet's Place</h1>
    <nav>
      <!-- TODO: write a "read" page which gives 5 random poems! -->
      <!-- <a class="nav-link" href="/readpoems.php">Read</a> -->
      <!-- <a class="nav-link" href="/posting.php">Post</a> -->
      <!-- <a class="nav-link" href="#">Review</a> -->
      <!-- <a class="nav-link" href="#">Delete</a> -->
      <a class="nav-link" href="/logout.php">Logout</a>
    </nav>
  </header>
  <main id="scrollable">
    <!-- Info -->
    <section class="description-section">
      <h3 class="section-heading">
        <?php
          if (isset($basic_data['uname'])) {
            echo $basic_data['uname']."'s Page";
          } else {
            echo "User's Page";
          }
        ?>
      </h3>
      <div class="side-img-box">
        <div>
          <!-- <p>
            Welcome back to your user homepage. Here, you can jump to private pages to post, preview, or delete your poems.
            Deleting one of your poems is <em>irreversible!</em> Posting a new poem will upload a new poem directly, but posting onto an existing poem by you will replace the old text. (Work in progress.)
          </p> -->
          <p>
            <?php
              if (isset($basic_data['uprofile'])) {
                echo $basic_data['uprofile'];
              } else {
                echo "Blank profile!";
              }
            ?>
          </p>
        </div>
        <div>
          <img class="side-img" src="./public/img/noble_bookshelf_flickr.png">
        </div>
      </div>
    </section>
  </main>
</body>