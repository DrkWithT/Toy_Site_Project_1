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
function fetchUserData(&$db_connection, $ssnid_cookie) {
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
    }
  }

  // set result data (NULL by default on any error!)
  $result['uname'] = $temp_usr_name;
  $result['uprofile'] = $temp_usr_desc;

  return $result;
}

$db_con = new mysqli(Util\DB_HOST_STR, "HelperUser1", "ZA4b_3c7D?", Util\DB_NAME);  // connect to DB first

if (!isset($_COOKIE['ssnID'])) {
  Util\redirectToPage(Util\SERVER_HOST_STR, ""); // redirect all visitors to homepage
} else if ($_COOKIE['ssnID'] == "none") {
  Util\redirectToPage(Util\SERVER_HOST_STR, "");
} else {
  $basic_data = fetchUserData($db_con, $_COOKIE['sessionID']);
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
          <img class="side-img" alt="bookshelf image" src="./public/img/noble_bookshelf_flickr.png">
        </div>
      </div>
    </section>
  </main>
</body>