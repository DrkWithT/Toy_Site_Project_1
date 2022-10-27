# README
## CSCI 12 Website Project: "A Poet's Place"
## By: Derek Tan

### General Info:
  - Frontend Languages: HTML, CSS 3, JS
  - Backend Tech: XAMPP with PHP 8.0+
  - VCS (Local): Git for Windows!

### Sumamry:
This is a _tentative_ outline of my final project for this web programming class. For this final project that I will eventually complete and present, I plan to create a basic writing website for posting small poems like haikus or sonnets. There, users can write, post, or manage their work in other ways. The outline below this summary will elaborate the details.

### Features:
 1. Basic User Authentication:
    - Creating an account: Needs a username, original password, confirm password, and _maybe_ an email (no 3rd party email verification, as it is beyond this class's scope).
    - Logging In: Needs a valid username and password. Password is at least 10 characters long with uppercase, lowercase, and numeric characters. Punctuation characters are necessary too: `'$', '!', '.'`.
    - Logging Out: The server-side scripts handle log out requests by clearing session ID cookies for a specific user doing so. A redirect to the homepage occurs anyway.
 2. Database for User Data:
    - Table 1: Maps usernames to passwords.
    - Table 2: Maps any valid username to a variable length JSON/XML string that lists poem IDs.
    - Table 3: Maps poem IDs to poem data: Title, Text
 3. Other:
    - ~~Users use buttons with hidden AJAX to do actions such as liking a poem.~~ (MAYBE)
    - Invalid URL GETs result in a special 404 page which links back to the homepage.

### Webpages:
 1. Appearance:
    - The style will be material design with slight to moderate CSS effects for visual appeal.
    - Icons from Font Awesome could be used for custom CSS and JS menus and buttons, but only the free-to-use ones? (MAYBE)
    - Possible Color Palettes:
      - [Dynamic Content Palette](https://colorpalettes.net/color-palette-2564/)
      - [General Palette](https://colorpalettes.net/color-palette-1960/)
 2. Structure:
  - On each page, there will be an immovable header with a fake site logo and a nav-bar containing links. Sometimes, the header will contain special text showing the username of a logged in user.
  - Note: The browser tab’s title will be in the format of “Site Name - Page Name”.
  - Below the header, which spans the width of the page, other content such as page descriptions, images, and forms are all scrollable. The scrollable area is in a single column layout.
  - The footer (homepage only) contains credits to me as the only programmer, and the date the project was started. However, the assignment info will be in comments for each file.
 3. Behavior:
  - Some front-end elements will have subtle CSS effects for visual appeal.
    - Pseudo class triggered CSS transitions: color, size, etc...
    - CSS animations for like buttons?
  - The HTML forms for posting poems, logging in, creating an account, and logging out. should use required HTML inputs. Other things such as maxlength and placeholder should be used for inputs whenever necessary. That feature can also avoid the unnecessary use of JS in place of a pre-made, HTML feature needing less code.
  - Any server error could redirect the user back to the home page _or_ show an error page.
 4. Types:
  - Guests and Users: Homepage, Signup, Login
  - Users Only: Logout confirmation page, User page (with links to user utility pages), and a dynamic poem viewing page. Each dynamic poem listing has 5 random poems. User utility pages will be for managing their poems by (re)posting, reading, or deleting.

### Server-Side PHP:
  - To be specified. I need to learn PHP first. I do know that they will likely interface with an SQL / SQLite3 database on my computer. Also, the site will be tested on `localhost` for demos.
  - TODO: learn PHP functions, classes (optional), redirection, further form validation, and mySQLI connections.
  - TODO: more picture decor! "Jump" index on homepage.
