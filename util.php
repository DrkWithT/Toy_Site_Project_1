<?php
/**
 * util.php
 * Contains misc. helper functions.
 * Derek Tan
 * TODO: Write functions for login and logout.
 */

namespace Util; // Declare a module for basic utility functions.

use mysqli;

/* Constants */
const DB_HOST_STR = "localhost";
const DB_NAME = "poetplace";
const SERVER_HOST_STR = "http://localhost:3000";

const SANIT_TRIM_SPC = 1;
const SANIT_HTML_ESC = 2;

/**
 * A helper function for redirecting to another page.
 */
function redirectToPage(string $host, string $page) {
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
 */
function sanitizeText($txt, $mode) {
  $new_txt = $txt;

  if ($mode >= SANIT_TRIM_SPC) {
    $new_txt = trim($new_txt);
  }

  if ($mode >= SANIT_HTML_ESC) {
    $new_txt = htmlspecialchars($new_txt);
  }

  return $new_txt;
}

/**
 * A helper function for checking a username with a password before any further action.
 */
function checkLogin($username, $password) {
  $success = ($username === "TestUser" && $password === "FooBar1234!"); // dummy check

  // TODO 1: more login checking with SQL later!
  //$auth_conn = mysqli(...);
  // TODO 2: use prepared SQL statements with user inputted data IF authenticated!

  // if the login is valid, assign session ID to track user
  // if ($success) {
  //   setcookie("sessionID", "testonly", 0, "/");
  // }

  return $success;
}

/**
 * Attempts to create an incoming user's entry in the table "Users".
 */
function tryRegister($uname, $pword_original, $pword_confirm) {
  $sanitized_uname = sanitizeText($uname, SANIT_HTML_ESC);
  $sanitized_pword1 = sanitizeText($pword_original, SANIT_HTML_ESC);
  $sanitized_pword2 = sanitizeText($pword_confirm, SANIT_HTML_ESC);

  $result = [
    "err" => TRUE,   // error exists?
    "sid" => "none"   // session id?
  ];

  $db_con = NULL;

  if (strlen($uname) >= 10 && $sanitized_pword1 === $sanitized_pword2) {
    // Connect with mySQLi credentials for connection and check for success...
    $db_con = new mysqli(DB_HOST_STR, "HelperUser1", "ZA4b_3c7D?", DB_NAME); // TODO: setup mySQL server accounts!
  }

  // IF all is ok, do the SQL operation...
  if (!$db_con->connect_error) {
    $pshash = password_hash($sanitized_pword1, PASSWORD_BCRYPT); // Securely encrypt the password by BCrypt!
    
    // Attempt to prepare SQL statement (check for SQL errors and pre-existing entry!).
    $new_usr_statement = $db_con->prepare("INSERT INTO Users (username, passhash) VALUE (?, ?)");
    $new_usr_statement->bind_param("ss", $sanitized_uname, $pshash);
    $new_usr_statement->execute();

    $result['err'] = $db_con->errno != 0; // get errno for 1st SQL operation

    if (!$result['err']) {
      $ssn_id_temp = uniqid("A2cF4", TRUE); // make special ID string for "ssn_id" cookie
      
      if ($db_con->query("INSERT INTO UserSsns (s_id, s_usr) VALUE ($ssn_id_temp, $sanitized_uname)") == TRUE) {
        $result['sid'] = $ssn_id_temp;
      }
    }

    $result['err'] = $db_con->errno != 0; // get errno for 2nd SQL operation
    
    // Close mySQL connection...
    $db_con->close();
  }

  return $result;
}

exit(0);
?>
