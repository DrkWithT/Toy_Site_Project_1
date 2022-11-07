<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="./public/css/index.css" rel="stylesheet">
  <link href="./public/css/forms.css" rel="stylesheet">
  <title>A Poet's Place - Posting</title>
</head>
<body>
  <header>
    <h1 id="site-title">A Poet's Place</h1>
    <nav>
      <a href="user.php">User Page</a>
    </nav>
  </header>
  <main id="scrollable">
    <!-- Info -->
    <section class="description-section">
      <h3 class="section-heading">Post New Poem</h3>
      <div class="side-img-box">
        <div>
          <p>
            This is the place to post a new poem. Poems must be titled and at least 50 characters long.
          </p>
          <form id="post-form" class="page-form" action="|" method="post">
            <div>
              <!-- Poem Title -->
              <label class="form-label" for="poem-title">Title</label>
              <input id="title-field" class="form-field" name="title" type="text" maxlength="56" minlength="8" required>
            </div>
            <div>
              <!-- Poem Text -->
              <label class="form-label" for="poem-text">Text</label>
              <textarea id="poem-text" class="form-text" placeholder="Type or paste your work here"></textarea>
            </div>
            <div class="form-item">
              <input id="submit-btn" type="submit" value="Submit">
            </div>
          </form>
        </div>
        <div>
          <img class="side-img" src="./public/img/noble_bookshelf_flickr.png">
        </div>
      </div>
    </section>
  </main>
</body>
</html>