# README
## CSCI 12 Website Project: "A Poet's Place"
## By: Derek Tan

### Summary:
This is a _tentative_ outline of my final, _toy_ project for this web programming class. For this final project that I will eventually complete and present, I plan to create a basic writing website for posting small poems like haikus or others. There, users can write, post, or manage their work in other ways. The notes below will elaborate the details.

### General Info:
  - Frontend Languages: HTML, CSS 3, JS
  - Backend Tech: XAMPP with PHP 8.0+
  - Version Control: Git for Windows
  - TIP: In _Visual Studio Code_, right click this file's editor tab and select "Open Preview".

### CODE SIZE:
~1577 lines, including blank lines and comments. Git files and README excluded.

### How to Use:
 1. Install _XAMPP_ for your computer.
 2. Then install the _Visual Studio Code_ editor on your computer.
 3. After installing VSCode, install the _PHP Intelliphense_ and _PHP Server_ editor extension.
 4. Clone this repo to download locally. Or get this project folder as a zip to unzip later.
 5. Run the _XAMPP Control Panel_ as administrator or superuser.
 6. Select "Admin" for "mySQL".
 7. Using "phpMyAdmin" on `localhost`, construct a database named `poetplace` with the tables described in Features Part 2.
 8. Open the project folder in the editor. Right click `homepage.html` and select "Serve PHP Project".

### Features:
 1. **Basic User Authentication**:
    - Signup: Needs a username, original password, and confirm a password.
    - Logging In: Needs a valid username and password. Password is at least 12 characters long with uppercase, lowercase, and numeric characters. Punctuation characters are necessary too: `'$', '!', '.'`.
    - Logging Out: The server-side scripts handle log out requests by clearing session ID cookies and a session DB entry for a specific user doing so. A redirect to the homepage occurs anyway.
 2. **Database**:
    - _users_: Maps `VARCHAR(60) username` to `VARCHAR(255) passhash` along with some `VARCHAR(300) userdesc`.
    - _works_: Maps `INTEGER id` to `VARCHAR(48) title, VARCHAR(60) author, VARCHAR(480) prose`.
      - The poem ID is `PRIMARY KEY` with `AUTO_INCREMENT`.
      - Fields here are `NOT NULL`.
    - _ssns_: Maps `VARCHARS(255) ssnid` to `VARCHAR(60) username`.
      - The user session ID strings use the PHP `uniqid()` function.

### Implementation Notes:
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

### PHP Scripts or Files: (Page Briefs)
 1. The `util.php` script contains common constants and helper functions used across the other dynamic PHP pages.
 2. The `htmlgen.php` script contains helper functions to generate dynamic html to echo in `works.php` and `poempanel.php`.
 3. The `login.php`, `logout.php`, `register.php` pages all do user sign in, sign out, and sign up with _cookie vs. database_ based authentication. See the code for more details.
 4. The `user.php` page is a page only visible to logged in users for now. This special page is the landing page for any site member, and it loads username and profile info from a database connection.
 5. The `poempanel.php` page contains a special, multi-mode form for creating, updating, or deleting a poem for the logged in user.
 6. The `works.php` page contains AJAX to dynamically load or query poems by their specific ID or range of ID numbers.
 7. Other:
  - The PHP will likely interface with the mySQL Server on my computer. Also, the site will be tested on `localhost` for demos.
  - **DONE**: Refactor PHP pages as postbacks!
    - Postbacks are PHP pages that handle their own POST requests with hidden PHP.
  - **WIP**: Add jQuery and vanilla client JS.
