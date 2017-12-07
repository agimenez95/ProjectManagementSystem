<?php
include_once "../logic/prereq.php";
$taskman = new TaskManager(getDB());
if ($_SESSION['page'] == 1) {
  $table = $taskman->allPending();
} elseif ($_SESSION['page'] == 2) {
  $table = $taskman->allCompleted();
}
?>
<form class="" action="singletask.php" method="post">
<?php
  if ($table) {
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
      echo "<tr>";
        $number = $index + 1;
        echo "<td>$number</td>";
        echo "<td>".$row['title']."</td>";
        echo "<td>".$row['firstname']." ".$row['surname']."</td>";
        echo "<td>".$row['email']."</td>";
        echo "<td>".$row['progress']."</td>";
        echo "<td><input class='btn btn-warning' type='submit' name='".$row['taskId']."' value='edit'></td>";
        echo "<td><input class='btn btn-info' type='submit' name='".$row['taskId']."' value='view'></td>";
      echo "</tr>";
    }
  } else {
    echo "<p>No tasks available.</p>";
  }
  ?>
  </table>
</form>
