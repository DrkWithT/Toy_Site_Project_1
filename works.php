<?php
  /**
   * works.php
   * Services the poem viewing page. Users can only view 5 works at a time, from a starting query ID to a hidden end ID.
   */

  require "./utils/util.php";
  require "./utils/htmlgen.php";

  use function Util\matchSessionID;
  use function PrintUtils\printPoemDiv;

  /* Shared Vars */
  $ssn_usr_name = NULL;  // Shared Var: The session user. Means "Anonymous" by default!
  $fetched_works = NULL;  // Shared Var: The mixed array to write as a list of 5 poems. Data is from the DB.

  /* Helper Funcs */
  /**
   * Fetches an array of 5 poem data objects.
   * @param mysqli &$db_connection A reference to an external SQL connection object.
   * @param int $start ID for first poem to get.
   * @param int $end ID for last poem to get.
   * @return array A listing of 5 associative arrays, each with title, author, and text.
   */
  function handlePoemSearch(&$db_connection, $start, $end) {
    $result = [];

    $con_ok = $db_connection->connect_errno == 0;
    $query_raw_data = NULL;

    if ($con_ok) {
      $query_raw_data = $db_connection->query("SELECT title, author, prose FROM works WHERE id >= " . $start . " AND " . "id <= " . $end);
    }

    if ($query_raw_data != NULL) {
      $result = $query_raw_data->fetch_all(MYSQLI_NUM);
    }

    return $result;
  }

  $db_con = new mysqli(Util\DB_HOST_STR, "HelperUser1", "ZA4b_3c7D?", Util\DB_NAME);  // connect to DB first
  $ssn_usr_name = matchSessionID($db_con, $_COOKIE['ssnID']);

  /* Postback */
  if ($_SERVER['REQUEST_METHOD'] == "GET") {
    // only handle form query requests!
    if (isset($_GET['startid'])) {
      $query_start = intval($_GET['startid']); // first ID to fetch a poem from
      $query_end = $query_start + 4;           // last ID to fetch a poem from
      
      $fetched_works = handlePoemSearch($db_con, $query_start, $query_end);
    }
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
  <link href="./public/css/works.css" rel="stylesheet">
  <title>A Poet's Place - Works</title>
</head>
<body>
  <!-- Header and Nav -->
  <header>
    <h1 id="site-title">A Poet's Place</h1>
    <nav>
      <a class="nav-link" href="/homepage.html">Homepage</a>
      <?php
        /* Note: Only shows user pages for logged in visitors! */
        if (strcmp($ssn_usr_name, "none") != 0) {
          echo "<a class=\"nav-link\" href=\"/user.php\">User</a>
          <a class=\"nav-link\" href=\"/logout.php\">Logout</a>";
        }
      ?>
    </nav>
  </header>
  <main id="scrollable">
    <section class="description-section">
      <div class="side-img-box">
        <div>
          <!-- Dynamic Username Heading -->
          <h3 class="section-heading">
            Reading&nbsp;As&nbsp;
            <?php
              if (strcmp($ssn_usr_name, "none") != 0) {
                echo $ssn_usr_name;
              } else {
                echo "Anonymous";
              }
            ?>
          </h3>
          <!-- Search Form -->
          <form method="GET" action="works.php">
            <label class="form-label" for="poem-id-field">Start ID</label>
            <input id="poem-id-field" class="form-field" name="startid" type="number" min="0" value="0">
            <input id="submit-btn" type="submit" value="Search">
          </form>
        </div>
        <div>
          <img class="side-img" alt="bookshelf image" src="./public/img/noble_bookshelf_flickr.png">
        </div>
      </div>
    </section>
    <section class="description-section">
      <h3 class="section-heading">Results</h3>
      <ul>
        <?php
          /* Note: Dynamically show poem text here. */
          if ($fetched_works != NULL) {
            if (count($fetched_works) > 0) {
              foreach ($fetched_works as $poem_data) {
                echo printPoemDiv($poem_data[0], $poem_data[1] , $poem_data[2]);
              }
            } else {
              "<p>No results!</p>";
            }
          } else {
            echo "<p>No results!</p>";
          }
        ?>
      </ul>
    </section>
  </main>
</body>
</html>