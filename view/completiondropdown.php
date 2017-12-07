<select class="progress" name="progress">


<?php
if ($_SESSION['progress'] == "Not Started") {
  echo '<option selected value="Not Started">Not Started</option>
    <option value="In Progress">In Progress</option>
    <option value="Completed">Completed</option>';
} elseif ($_SESSION['progress'] == "In Progress") {
  echo '<option value="Not Started">Not Started</option>
    <option selected value="In Progress">In Progress</option>
    <option value="Completed">Completed</option>';
} elseif ($_SESSION['progress'] == "Completed") {
  echo '<option value="Not Started">Not Started</option>
        <option value="In Progress">In Progress</option>
        <option selected value="Completed">Completed</option>';
}
?>
</select>
