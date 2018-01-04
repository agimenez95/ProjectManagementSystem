<?php
include_once "navbar.php";
if (isset($_SESSION['numberOfDropdowns']) && $_SESSION['page'] != 3){
  unset($_SESSION['numberOfDropdowns']);
}
echo "<div class='container'>";
if ($_SESSION['page'] == 1) {
  echo "<h3>In Progress</h3>";
  include_once "manager/viewtasks.php";
} elseif ($_SESSION['page'] == 2) {
  echo "<h3>Completed Tasks</h3>";
  include_once "manager/viewtasks.php";
} elseif ($_SESSION['page'] == 3) {
  echo "<h3>Create a Task</h3>";
  if (isset($_SESSION['edit'])) {
    unset($_SESSION['edit']);
  }
  if (isset($_SESSION['taskId'])) {
    unset($_SESSION['taskId']);
  }
  include_once "manager/createtask.php";
} elseif ($_SESSION['page'] == 4) {
  echo "<h3>Upgrade Account</h3>";
  include_once "manager/upgradeaccount.php";
} elseif ($_SESSION['page'] == 5) {
  echo "<h3>All Users</h3>";
  include_once "manager/showusers.php";
}
?>
