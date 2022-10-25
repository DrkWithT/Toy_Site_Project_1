<?php
/**
 * user.php
 * Services a generic user's home page.
 * Derek Tan
 */

/* Imports */
use function Util\redirectToPage;

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
  <!-- Special CSS for Lists of userpage anchorlinks! -->
  <style>
    ul#user-links {
      display: flex;
      flex-direction: row;
      list-style: none;
    }

    li.user-link-item {
      display: block;
      margin: 8px;
      padding: 4px;
    }

    a.user-page-link {
      display: block;
      margin: 0;
      padding: 8px;
      text-decoration: none;
      transition: background-color 0.5s;
      transition-delay: 1s;
      background-color: #8d7361;
      color: white;
    }

    a.user-page-link:hover {
      background-color: #b09684;
      color: whitesmoke;
    }
  </style>
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
  <main id="scrollable">
    <!-- Info -->
    <section class="description-section">
      <h3 class="section-heading">About You</h3>
      <p>
        This is your user homepage where you can manage your written works. Work in progress!
      </p>
    </section>
    <section class="description-section">
      <h3 class="section-heading">Manage Your Works</h3>
      <p>
        Here, you can post, preview, or delete your poems. Posting a new poem will upload a new poem directly, but posting onto an existing poem by yourself will replace the old text. (Work in progress.)
      </p>
      <!-- TODO: add post, preview, delete PHP pages. -->
      <ul id="user-links">
        <li class="user-link-item">
          <a class="user-page-link" href="#">Post</a>
        </li>
        <li class="user-link-item">
          <a class="user-page-link" href="#">Preview</a>
        </li>
        <li class="user-link-item">
          <a class="user-page-link" href="#">Delete</a>
        </li>
      </ul>
    </section>
  </main>
</body>