<?php
  /**
   * htmlgen.php
   * Contains utility constants and functions that help generate dynamic html for PHP pages.
   * Derek Tan
   */
  namespace PrintUtils;

  /* Helper Funcs */
  function printPoemDiv(string $title, string $author, string $text) {
    // open div html
    $result = "<div class=\"work-section\">";

    // append title by PHP template string
    $result .= "<h4>{$title} by {$author}</h4>";

    // append paragraph html
    $result .= "<p class=\"work-content\">{$text}</p>";

    // close div html
    $result .= "</div>";

    return $result;
  }

  function printPoemLI(int $poem_id, string $poem_title) {
    // open li html
    $result = "<li class=\"work-brief\">";

    // append dynamic poem entry data as PHP template string
    $result .= "Poem {$poem_id} is \"{$poem_title}\"";

    // close li html
    $result .= "</li>";

    return $result;
  }
  
?>