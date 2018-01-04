<?php
include_once "../logic/prereq.php";
if ($_POST['sortingOption'] == "Time") {
  $_SESSION['sortingOption'] = "Time";
} elseif ($_POST['sortingOption'] == "All") {
  $_SESSION['sortingOption'] = "All";
} elseif ($_POST['sortingOption'] == "In Progress") {
  $_SESSION['sortingOption'] = "In Progress";
} elseif ($_POST['sortingOption'] == "Not Started") {
  $_SESSION['sortingOption'] = "Not Started";
}
header('Location: '.$_SERVER['HTTP_REFERER']);
?>
