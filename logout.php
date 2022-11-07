<?php
use function Util\redirectToPage;

setcookie("sessionID", "none", 0, "/"); // erase sessionID
redirectToPage(""); // return to homepage after logout
exit(0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>A Poet's Place - Logout</title>
</head>
<body>
  <p>See you later!</p>
</body>
</html>