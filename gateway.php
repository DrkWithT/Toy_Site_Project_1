<?php
/**
* gateway.php
* Redirects all valid logins to their user page, and redirects invalid logins to homepage.
* Derek Tan
*/

namespace Util; // Declare a module for basic utility functions.
/**
 * A helper function for checking a username with a password before any further action.
 */
function checkLogin($username, $password)
{
  $success = ($username === "TestUser" && $password === "FooBar1234!"); // dummy check

  // TODO: more login checking with SQL later

  // if the login is valid, assign session ID to track user
  if ($success)
    setcookie("sessionID", "testonly", 0, "/");

  return $success;
}

/**
 * A helper function for redirecting to another page.
 */
function redirectToPage(string $page)
{
  $temp = "";

  if (strlen($page) > 0)
    $temp = $page;
  else
    $temp = "homepage.html";

  header("Location: http://localhost:3000/".$temp);
}

if ($_SERVER['REQUEST_METHOD'] === "POST")
{
  $loginValid = checkLogin($_POST['username'], $_POST['password']);

  if ($loginValid)
    redirectToPage("user.php");
  else
    redirectToPage("login.php");
}
else
  echo "Invalid request.";

exit(0);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>A Poet's Place - Redirect</title>
</head>

<body>
  <p>You are being redirected.</p>
</body>

</html>