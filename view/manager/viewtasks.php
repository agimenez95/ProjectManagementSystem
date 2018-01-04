<?php
include_once "../logic/prereq.php";
$taskman = new TaskManager(getDB());
if ($_SESSION['page'] == 1) {
  echo '<form class="" action="../logic/setorderingoption.php" method="post">
  Order by: ';
  include_once "../logic/orderingoptiondropdown.php";
  echo ' <input class="btn btn-info" type="submit" name="submit" value="Update Table">
  </form>';
  $table = $taskman->allPending($_SESSION['sortingOption']);
} elseif ($_SESSION['page'] == 2) {
  $table = $taskman->allCompleted();
}
if ($table) {
  echo "<p>".$table['userId']."</p>";
  echo "<table class='table'>
    <tr>
      <th>Task</th>
      <th>Title</th>
      <th>Name</th>
      <th>Email</th>
      <th>Progress</th>
      <th></th>
      <th></th>
    </tr>";
  foreach ($table as $index => $row) {
    echo "<form class='' action='singletask.php' method='post'>";
      echo "<tr>";
        $number = $index + 1;
        echo "<td>$number <input type='hidden' name='taskUserId' value='".$row['userId']."'></td>";
        echo "<td>".$row['title']."</td>";
        echo "<td>".$row['firstname']." ".$row['surname']."</td>";
        echo "<td>".$row['email']."</td>";
        echo "<td>".$row['progress']."</td>";
        echo "<td><input class='btn btn-warning' type='submit' name='".$row['taskId']."' value='Edit'></td>";
        echo "<td><input class='btn btn-info' type='submit' name='".$row['taskId']."' value='View'></td>";
      echo "</tr>";
    echo "</form>";
  }
} else {
  echo "<p>No tasks available.</p>";
}
?>
</table>
