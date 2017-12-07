<?php
include_once "navbar.php";
if ($_SESSION['page'] == 1) {
  echo "<div class='container'>";
  echo "<h3>In Progress</h3>";
  include_once "manager/viewtasks.php";
} elseif ($_SESSION['page'] == 2) {
  echo "<div class='container'>";
  echo "<h3>Completed Tasks</h3>";
  include_once "manager/viewtasks.php";
} elseif ($_SESSION['page'] == 3) {
  echo "<div class='container'>";
  echo "<h3>Create a Task</h3>";
  if (isset($_SESSION['edit'])) {
    unset($_SESSION['edit']);
  }
  if (isset($_SESSION['taskId'])) {
    unset($_SESSION['taskId']);
  }
  include_once "manager/createtask.php";
} elseif ($_SESSION['page'] == 4) {
  echo "<div class='container'>";
  echo "<h3>Upgrade Account</h3>";
  include_once "manager/upgradeaccount.php";
}
?>
