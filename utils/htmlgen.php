<?php
  /**
   * htmlgen.php
   * Contains utility constants and functions that help generate dynamic html for PHP pages.
   * Derek Tan
   */
  namespace PrintUtils;

  const BEG_POEM_DIV = "<div class=\"work-section\">";
  const END_DIV = "</div>";
  const BEG_TITLING = "<h4>";
  const END_TITLING = "</h4>";
  const BEG_PAR = "<p class=\"work-content\">";
  const END_PAR = "</p>";

  function printPoemDiv(string $title, string $author, string $text) {
    // open div html
    $result = BEG_POEM_DIV;

    // append title
    $result .= BEG_TITLING;
    $result .= "{$title} by {$author}";  // use php template string
    $result .= END_TITLING;

    // append paragraph html
    $result .= BEG_PAR;
    $result .= $text;
    $result .= END_PAR;

    // close div html
    $result .= END_DIV;

    return $result;
  }
  
?>