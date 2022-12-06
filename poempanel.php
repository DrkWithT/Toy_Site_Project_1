<?php
  /**
   * posting.php
   * This is the utility page for a user. Here, this PHP script handles posting new poems to the DB.
   * Derek Tan
   */

  require "./utils/util.php";
  require "./utils/htmlgen.php";

  use function Util\matchSessionID;
  use function Util\redirectToPage;
  use function Util\sanitizeText;
  use function PrintUtils\printPoemLI;

  /* Shared Vars */
  $ssn_usr_name = NULL;   // Shared Var for PHP page: Pre-fetched username for session
  $usr_work_list = NULL;  // Shared Var: Data to echo: ID to title list
  $msg_code = 0;          // Shared Var: Integer to choose bad error messages, in the header

  /**
   * Fetches a 2-d associative array of brief poem data: (ID, title).
   * @param mysqli &$db_connection Reference to external SQL connection.
   * @param string $ssn_uname Session's user by name.
   * @return array A numeric keyed, 2D array.
   * ```
   * $results = [
   *    ["<id>", "Ode To PHP"],
   *    ["<id>", "Tuned Broadcasts"]
   * ];
   * ```
   */
  function handlePoemGets(&$db_connection, $ssn_uname) {
    $results = NULL;

    if ($db_connection->connect_errno != 0) {
      return $results;
    }
    
    $fetch_result = $db_connection->query("SELECT id, title FROM works WHERE author='" . $ssn_uname . "'");
    
    if ($fetch_result != FALSE) {
      $results = $fetch_result->fetch_all(MYSQLI_NUM);
    }

    return $results;
  }

  /**
   * Updates the poem storing database from user form input. 
   * @param mysqli &$db_connection Reference to an external SQL connection.
   * @param string $ssn_uname Session username. Must be sanitized before.
   * @param string $clean_title Title string. Must be sanitized before.
   * @param string $clean_text Poem content string. Must be sanitized before.
   * @return int A status code. 0 means normal success, 1 means SQL connect failure, 2 means SQL query failure.
   */
  function handlePoemAdd(&$db_connection, $ssn_uname, $clean_title, $clean_text) {
    $status_code = 0;

    $lined_text = str_ireplace("*", "<br>", $clean_text);

    if (strlen($lined_text) > 480) { 
      $status_code = 1; // invalid input code
      return $status_code;
    }

    if ($db_connection->connect_errno != 0) {
      $status_code = 2; // connection failure code
      return $status_code;
    }

    $adding_status = $db_connection->query("INSERT INTO works (title, author, prose) VALUES ('"
      . $clean_title . "', '" . $ssn_uname . "', '" . $lined_text . "')"); // id is omitted since it's auto incremented!

    if (!$adding_status) {
      $status_code = 3; // SQL operation failure code
    }

    return $status_code;
  }

  /**
   * Deletes a work from the DB, only if it's by a real site member.
   * @param mysqli &$db_connection Reference to an external SQL connection.
   * @param string $ssn_uname Session username.
   * @param int $target_poem_id ID number of the poem to delete.
   * @return int A status code. 0 means normal success, 1 means SQL connect failure, 2 means SQL query failure.
   */
  function handlePoemDel(&$db_connection, $ssn_uname, $target_poem_id) {
    $status_code = 0;

    // NOTE: validate parameter in case of user forced garbage input!
    if ($target_poem_id <= 0) {
      $status_code = 1;
      return $status_code;
    }

    if ($db_connection->connect_errno != 0) {
      $status_code = 2;
      return $status_code;
    }

    $delete_status = $db_connection->query("DELETE FROM works WHERE id=" . $target_poem_id . " AND author='" . $ssn_uname . "'");

    if (!$delete_status) {
      $status_code = 3;
    }

    return $status_code;
  }

  /**
   * Helper function for printing poem panel status messages.
   * @param int $msg_code
   */
  function putBannerMsg($ext_msg_code) {
    switch ($ext_msg_code) {
      case 0:
        echo "<h4 id=\"error-banner\">Success!</h4>";
        break;
      case 1:
        echo "<h4 id=\"error-banner\">Invalid inputs.</h4>";
        break;
      case 2:
        echo "<h4 id=\"error-banner\">The database is unreachable.</h4>";
        break;
      case 3:
        echo "<h4 id=\"error-banner\">We had a database problem.</h4>";
        break;
      case 4:
        echo "<h4 id=\"error-banner\">Invalid app action.</h4>";
        break;
      default:
        break;
    }
  }

  /* Postback */
  // Do not accept unauthorized guests!
  if (!isset($_COOKIE['ssnID'])) {
    redirectToPage(Util\SERVER_HOST_STR, "");
    exit(0);
  }

  if (strcmp($_COOKIE['ssnID'], "none") == 0) {
    redirectToPage(Util\SERVER_HOST_STR, "");
    exit(0);
  }

  $db_con = new mysqli(Util\DB_HOST_STR, "HelperUser1", "ZA4b_3c7D?", Util\DB_NAME);  // connect to DB first
  $ssn_usr_name = matchSessionID($db_con, $_COOKIE['ssnID']);

  // Check if session user exists!
  if (strcmp($ssn_usr_name, "none") == 0) {
    $db_con->close();
    redirectToPage(Util\SERVER_HOST_STR, "");
    exit(0);
  }

  $usr_work_list = handlePoemGets($db_con, $ssn_usr_name); // fetch any works by the user (likely a member?)

  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // get form data
    $panel_action = "nop";
    $cleaned_title = "New Work";
    $cleaned_text = "Filler text.";
    $cleaned_id = 0;

    if (isset($_POST['action'])) {
      $panel_action = $_POST['action'];
    }

    if (isset($_POST['title'])) {
      $cleaned_title = sanitizeText($_POST['title']);
    }

    if (isset($_POST['text'])) {
      $cleaned_text = sanitizeText($_POST['text']);
    }
    
    if (isset($_POST['pid'])) {
      $cleaned_id = $_POST['pid'];
    }

    // execute user panel action
    if (strcmp($panel_action, "publish") == 0) {
      $msg_code = handlePoemAdd($db_con, $ssn_usr_name, $cleaned_title, $cleaned_text);
    } else if (strcmp($panel_action, "delete") == 0) {
      $msg_code = handlePoemDel($db_con, $ssn_usr_name, $cleaned_id);
    } else {
      $msg_code = 4;
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
  <!-- Icon -->
  <link rel="shortcut icon" href="./public/img/favicon.ico" type="image/x-icon">
  <title>A Poet's Place - Poem Panel</title>
</head>
<body>
  <header>
    <h1 id="site-title">A Poet's Place</h1>
    <?php putBannerMsg($msg_code); ?>
    <nav>
      <a class="nav-link" href="/user.php">User</a>
      <a class="nav-link" href="/works.php">Read</a>
      <a class="nav-link" href="/logout.php">Logout</a>
    </nav>
  </header>
  <!-- Side Nav Index -->
  <div id="side-nav">
    <a class="side-nav-link" href="#">To Top</a>
    <a class="side-nav-link" href="#posting-area">To Post</a>
    <a class="side-nav-link" href="#list-area">To List</a>
  </div>
  <main id="scrollable">
    <!-- Info -->
    <section class="description-section">
      <h3 id="posting-area" class="section-heading">
        Welcome,&nbsp;<?php echo $ssn_usr_name; ?>
      </h3>
      <div class="side-img-box">
        <div>
          <p>
            This is the place to post or delete a poem. If you post, a poem must be titled and at least 48 characters long. Also, separate lines must be ended by <code>*</code>.
          </p>
          <form id="post-form" class="page-form" action="/poempanel.php" method="POST">
            <div id="action-form">
              <!-- Poem Panel Action -->
              <label class="form-label" for="poem-nop">None</label>
              <input id="poem-nop" class="radio-input" type="radio" name="action" value="nop">
              <label class="form-label" for="poem-add">Publish</label>
              <input id="poem-add" class="radio-input" type="radio" name="action" value="publish">
              <label class="form-label" for="poem-del" value="publish">Delete</label>
              <input id="poem-del" class="radio-input" type="radio" name="action" value="delete">
            </div>
            <div id="title-form">
              <!-- Poem Title -->
              <label class="form-label" for="poem-title">Title</label>
              <input id="poem-title" class="form-field" name="title" type="text" placeholder="Title here" maxlength="48" minlength="8" required>
            </div>
            <div id="text-form">
              <!-- Poem Text -->
              <label class="form-label" for="poem-text">Text</label>
              <textarea id="poem-text" class="form-text" name="text" placeholder="Text here" minlength="24" maxlength="480" rows="12" cols="20" required></textarea>
            </div>
            <div id="id-form">
              <!-- Poem ID Number -->
              <label class="form-label" for="poem-id">Poem ID</label>
              <input id="poem-id" class="form-field" name="pid" type="number" min="0">
            </div>
            <div class="form-item">
              <input id="submit-btn" type="submit" value="Submit">
            </div>
          </form>
        </div>
        <div>
          <img class="side-img" alt="bookshelf image" src="./public/img/noble_bookshelf_flickr.png">
        </div>
      </div>
    </section>
    <section class="description-section">
      <h3 id="list-area" class="section-heading">Your Works</h3>
      <ul id="usr-work-list">
        <?php
          /* Note: Works by this session's user echo here. */ 
          if ($usr_work_list != NULL) {
            if (count($usr_work_list) > 0) {
              foreach($usr_work_list as $key => $current_work) {
                echo printPoemLI($current_work[0], $current_work[1]);
              }
            } else {
              echo "<li class=\"work-brief\">Nothing written.</li>";
            }
          } else {
            echo "<li class=\"work-brief\">Could not load!</li>";
          }
        ?>
      </ul>
    </section>
  </main>
  <!-- JS -->
  <script src="./public/js/panel_form.js"></script>
</body>
</html>