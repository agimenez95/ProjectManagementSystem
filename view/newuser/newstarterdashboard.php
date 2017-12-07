<?php
include_once "navbar.php";
if ($_SESSION['page'] == 1) {
  include "viewtasks.php";
} elseif ($_SESSION['page'] == 2) {
  include "viewtasks.php";
} elseif ($_SESSION['page'] == 3) {
  echo "<p>New Manager</p>";
} elseif ($_SESSION['page'] == 4) {
  echo "<p>Completed Tasks</p>";
}
?>
