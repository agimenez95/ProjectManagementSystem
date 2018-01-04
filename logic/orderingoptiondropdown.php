<?php
include_once "../logic/prereq.php";
echo '<select class="selectpicker" name="sortingOption">';
if ($_SESSION['sortingOption'] == "All") {
  echo '<option value="Time">Tasks Last Updated</option>
    <option selected value="All">Split Tasks by Progress</option>
    <option value="In Progress">Only In Progress</option>
    <option value="Not Started">Only Tasks Not Started</option>';
} elseif ($_SESSION['sortingOption'] == "In Progress") {
  echo '<option value="Time">Tasks Last Updated</option>
    <option value="All">Split Tasks by Progress</option>
    <option selected value="In Progress">Only In Progress</option>
    <option value="Not Started">Only Tasks Not Started</option>';
} elseif ($_SESSION['sortingOption'] == "Not Started") {
  echo '<option value="Time">Tasks Last Updated</option>
    <option value="All">Split Tasks by Progress</option>
    <option value="In Progress">Only In Progress</option>
    <option selected value="Not Started">Only Tasks Not Started</option>';
} else {
  echo '<option selected value="Time">Tasks Last Updated First</option>
    <option value="All">Split Tasks by Progress</option>
    <option value="In Progress">Only In Progress</option>
    <option value="Not Started">Only Tasks Not Started</option>';
}
echo '</select>';
?>
