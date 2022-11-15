<?php
/**
 * util.php
 * Contains misc. helper functions.
 * Derek Tan
 * NOTE: remove debugs. Check function matchSsnUser().
 */

namespace Util; // Declare a module for other helper functions.

use mysqli;

/* Constants */

const DB_HOST_STR = "localhost";
const DB_NAME = "poetplace";
const SERVER_HOST_STR = "http://localhost:3000/";
const UNIQID_PREFIX = "A2cF4";

/* Misc. Helpers */

/**
 * A helper function for redirecting to another page.
 * @param string $host Server's IP or `localhost`.
 * @param string $page The name of the page with file extension. Defaults to homepage.html!
 */
function redirectToPage($host, $page) {
  $temp = "";

  if (strlen($page) > 0) {
    $temp = $page;
  } else {
    $temp = "homepage.html";
  }

  header("Location:".$host.$temp);
}

/**
 * A helper function for sanitizing a user's input strings.
 * Has two modes denoted by constants in the Util Namespace: trim spaces and escaping html sequences.
 * @param string $txt
 */
function sanitizeText($txt) {
  return htmlspecialchars(trim($txt));
}

/* Session Helpers */

/**
 * Updates the DB with an active session entry after setting an ssnID cookie.
 * The username `uname` must be a sanitized string and `ssn_id_value` must be from the DB.
 * @param mysqli &$db_connection A reference to a SQL connection.
 * @param string $uname A pre-sanitized username string.
 * @param string $ssn_id_value A specific session ID string.
 * @return bool `TRUE` if a new session entry is inserted to the DB. 
 */
function createSession(&$db_connection, $uname, $ssn_id_value) {
  $create_ssn_ok = FALSE; // checks SQL INSERT success
  
  // exit early when connection is bad
  if ($db_connection->connect_errno != 0) {
    return $create_ssn_ok;
  }

  $sql = "INSERT INTO ssns VALUES ('" . $ssn_id_value . "', '" . $uname . "')";
  setcookie("ssnID", $ssn_id_value, 0, "/", "", FALSE, TRUE);
  
  $create_ssn_ok = $db_connection->query($sql);

  return $create_ssn_ok;
}

/**
 * Used for user logouts, as it clears a session entry from the DB along with the `ssnID` cookie. 
 * @param mysqli &$db_connection A reference to a SQL connection.
 * @param string $uname A pre-sanitized username string.
 */
function destroySession(&$db_connection, $uname) {
  if ($db_connection->connect_errno != 0) {
    return;
  }

  $db_connection->query("DELETE FROM ssns WHERE username='" . $uname . "'"); // clear DB session on back-end DB!
  setcookie("ssnID", "none"); // clear ssnID cookie for client!
}

/**
 * Returns a valid username bound to a session by an ssnID cookie value.
 * If no such session exists with the given `ssnID` value, `"none"` is returned.
 * @param mysqli &$db_connection A reference to a SQL connection.
 * @param string $ssn_id_value A specific session ID string.
 * @return string The username associated with the session ID.
 */
function matchSessionID(&$db_connection, $ssn_id_value) {
  $ssn_user = "none";

  if ($db_connection->connect_errno != 0) {
    return $ssn_user;
  }

  $sql = "SELECT * FROM ssns WHERE ssnid='".$ssn_id_value."'";

  $query_result = $db_connection->query($sql);

  if ($query_result != FALSE) {
    $query_row = $query_result->fetch_assoc();

    if ($query_row != NULL) {
      $ssn_user = $query_row['username'];
    }
  }

  return $ssn_user;
}
?>
