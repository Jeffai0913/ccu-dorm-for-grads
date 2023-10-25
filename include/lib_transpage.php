<?php
// transpage logic


/**
 *         //\\         ||                  |||||||||||||\\     ||              ||         //\\
 *        //  \\        ||                  ||           \\\    ||              ||        //  \\
 *       //    \\       ||                  ||             ||   ||              ||       //    \\
 *      //      \\      ||                  ||           ///    ||              ||      //      \\
 *     //||||||||\\     ||                  |||||||||||||//     ||||||||||||||||||     //||||||||\\
 *    //          \\    ||                  ||                  ||              ||    //          \\
 *   //            \\   ||                  ||                  ||              ||   //            \\
 *  //              \\  ||||||||||||||||||  ||                  ||              ||  //              \\
 */

// EDIT WITH CATION!!!

const PERMS = ["adm", "dep", "qry", "sto", "std", "sww", "swn", "swo", "swd", "swa", "swd", "swa", "spo", "stq", "stn"];

if (isset($_GET["inner"])) {
  $filepath = "page/pg_" . $_GET["inner"] . ".html";
  if (file_exists($filepath)) {
    // transmap
    if (substr($_GET["inner"], 0, 3) === "map") {
      include "transmap.php";
    } else {
      include $filepath;
    }
  } else {
    // check if the file exist
    $filepath = substr($_GET["inner"], 0, 3) . "/" . $_GET["inner"] . ".php";
    if (file_exists($filepath)) {
      // check if the user is logged in
      if (isset($_SESSION["account"])) {
        // check if the user has the right permission
        if (is_allowed($_SESSION["perm"], $_GET["inner"])) {
          include $filepath;
        } else {
          // wrong permission
          // 403 Forbidden
          include "page/403.html";
        }
      } else {
        // logged out user try to access perms pages
        // 401 Unauthorized
        include "page/401.html";
      }
    } else {
      // 404 Not Found
      include "page/404.html";
    }
  }
} else {
  // entry pages
  if (isset($_SESSION["account"])) {
    // {perm}/{perm}_index.php
    if ($_SESSION["perm"][0] !== "s") {
      include $_SESSION["perm"] . "/" . $_SESSION["perm"] . "index.php";
    } else {
      include "stu/stuindex.php";
    }
  } else {
    include "div/div_home.php";
  }
}

function is_allowed($perm, $inner) {
  if ($inner[0] !== "s") {
    return substr($inner, 0, 3) === $perm;
  } else {
    return $perm[0] === "s" && in_array($perm, PERMS);
  }
}
