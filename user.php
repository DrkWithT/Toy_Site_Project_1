<?php
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

  header("Location: http://localhost:3000/" . $temp);
}

if (!isset($_COOKIE['sessionID']))
  redirectToPage(""); // redirect all visitors to homepage
else if ($_COOKIE['sessionID'] == "none")
  redirectToPage("");
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
      <a class="nav-link" href="/logout.php">Logout</a>
    </nav>
  </header>
  <main id="scrollable">
    <!-- Info -->
    <section class="description-section">
      <h3 class="section-heading">About You</h3>
      <p>
        This is your user homepage where you can manage your written works. Work in progress!
      </p>
    </section>
  </main>
</body>