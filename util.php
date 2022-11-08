<?php
/**
* util.php
* Contains misc. helper functions.
* Derek Tan
*/

namespace Util; // Declare a module for basic utility functions.

/**
 * A helper function for checking a username with a password before any further action.
 */
function checkLogin($username, $password) {
  $success = ($username === "TestUser" && $password === "FooBar1234!"); // dummy check

  // TODO 1: more login checking with SQL later!
  //$auth_conn = mysqli(...);
  // TODO 2: use prepared SQL statements with user inputted data IF authenticated!

  // if the login is valid, assign session ID to track user
  if ($success)
    setcookie("sessionID", "testonly", 0, "/");

  return $success;
}

/**
 * A helper function for redirecting to another page.
 */
function redirectToPage(string $page) {
  $temp = "";

  if (strlen($page) > 0) {
    $temp = $page;
  } else {
    $temp = "homepage.html";
  }

  header("Location: http://localhost:3000/".$temp);
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
  $loginValid = checkLogin($_POST['username'], $_POST['password']);

  if ($loginValid)
    redirectToPage("user.php");
  else
    redirectToPage("login.php");
} else {
  redirectToPage("homepage.html");
}

exit(0);
?>