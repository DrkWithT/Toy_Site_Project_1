<?php
/**
 * user.php
 * Services a generic user's home page.
 * Derek Tan
 */

/* Imports */
use function Util\redirectToPage;

if (!isset($_COOKIE['sessionID'])) {
  redirectToPage(""); // redirect all visitors to homepage
} else if ($_COOKIE['sessionID'] == "none") {
  redirectToPage("");
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
      <a class="nav-link" href="/logout.php">Logout</a>
    </nav>
  </header>
  <!-- Side Nav Index -->
  <div id="side-nav">
    <a class="side-nav-link" href="/posting.php">Post</a>
    <a class="side-nav-link" href="#">Review</a>
    <a class="side-nav-link" href="#">Delete</a>
  </div>
  <main id="scrollable">
    <!-- Info -->
    <section class="description-section">
      <h3 class="section-heading">About You</h3>
      <div class="side-img-box">
        <div>
          <p>
            Welcome back to your user homepage. Here, you can jump to private pages to manage your written poems.
            However, once you delete one of your poems, the action is irreversible!
          </p>
          <p>
            Using the other links, you can post, preview, or delete your poems. Posting a new poem will upload a new poem directly, but posting onto an existing poem by yourself will replace the old text. (Work in progress.)
          </p>
        </div>
        <div>
          <img class="side-img" src="./public/img/noble_bookshelf_flickr.png">
        </div>
      </div>
    </section>
  </main>
</body>