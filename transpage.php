<main id="main">
  <?php
  require "class/Token.php";

  // check if there's a key 
  if (isset($_COOKIE["jwt"])) {
    $token = $_COOKIE["jwt"];

    // verify the token
    $valid = Token::verify($token);
  }
  
    // check user status
    if (isset($valid)) {
      if ($valid) {
        $_SESSION["account"] = $valid;
        $_SESSION["perm"] = $valid["perm"];
      } else {
        // login failed
        header("HTTP/1.1 401 Unauthorized");
      }
    }

  // menu component
  include "include/lib_transmenu.php";

  // main content
  echo "<section id=\"right\">";

  // conditional rendering content
  include "include/lib_transpage.php";

  echo "</section>";
  ?>
</main>