<?php
  /**
   * htmlgen.php
   * Contains utility constants and functions that help generate dynamic html for PHP pages.
   * Derek Tan
   */
  namespace PrintUtils;

  /* Constants */
  const BEG_LI = "<li>";
  const END_LI = "</li>";
  const BEG_POEM_DIV = "<div class=\"work-section\">";
  const END_DIV = "</div>";
  const BEG_TITLING = "<h4>";
  const END_TITLING = "</h4>";
  const BEG_PAR = "<p class=\"work-content\">";
  const END_PAR = "</p>";

  /* Helper Funcs */
  function printPoemDiv(string $title, string $author, string $text) {
    // open div html
    $result = BEG_POEM_DIV;

    // append title by PHP template string
    $result .= BEG_TITLING;
    $result .= "{$title} by {$author}";
    $result .= END_TITLING;

    // append paragraph html
    $result .= BEG_PAR;
    $result .= $text;
    $result .= END_PAR;

    // close div html
    $result .= END_DIV;

    return $result;
  }

  function printPoemLI(int $poem_id, string $poem_title) {
    // open li html
    $result = BEG_LI;

    // append dynamic poem entry data as PHP template string
    $result .= "Poem {$poem_id} is \"{$poem_title}\"";

    // close li html
    $result .= END_LI;

    return $result;
  }
  
?>