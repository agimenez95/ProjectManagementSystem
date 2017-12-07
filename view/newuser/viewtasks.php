<?php
include_once "../logic/prereq.php";
$taskman = new TaskManager(getDB());
if ($_SESSION['page'] == 1) {
  $table = $taskman->byUserId($_SESSION["userId"]);
} elseif ($_SESSION['page'] == 2) {
  $completed = true;
  $table = $taskman->byUserId($_SESSION["userId"], $completed);
}
?>
<form class="" action="singletask.php" method="post">
<?php
  if ($table) {
    echo "<table class='table'>
      <tr>
        <th>Task Number</th>
        <th>Title</th>
        <th>Progress</th>
        <th></th>
      </tr>";
    foreach ($table as $index => $row) {
      echo "<tr>";
        $number = $index + 1;
        echo "<td>$number</td>";
        echo "<td>".$row['title']."</td>";
        echo "<td>".$row['progress']."</td>";
        echo "<td><input class='btn btn-info' type='submit' name='".$row['taskId']."' value='view'></td>";
      echo "</tr>";
    }
  } else {
    echo "<p>No tasks have been assigned to you.</p>";
  }

  ?>
  </table>
</form>
