<?php
include_once "navbar.php";
echo "<div class='container'>";
echo "<br>";
if ($_SESSION['page'] == 1) {
  echo "<h3>In Progress</h3>";
} elseif ($_SESSION['page'] == 2) {
  echo "<h3>Completed</h3>";
}
include "viewtasks.php";
?>
