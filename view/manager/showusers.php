<?php
include_once "../logic/prereq.php";
echo "<br>";
$userman = new UserManager(getDB());
$table = $userman->allUsers();
if ($table) {
  echo "<p>".$table['userId']."</p>";
  echo "<table class='table'>
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th>Is Manager?</th>
      <th></th>
    </tr>";
  foreach ($table as $row) {
    if (!$row['disabled']) {
      echo "<form class='' action='../logic/deleteuser.php' method='post'>";
        echo "<tr>";
          echo "<td>".$row['firstname']." ".$row['surname']."</td>";
          echo "<td>".$row['email']."</td>";
          if ($row['isManager']) {
            echo "<td>Yes</td>";
          } else {
            echo "<td>No</td>";
          }
          echo "<td><input class='btn btn-danger' type='submit' name='".$row['id']."' value='Delete User'></td>";
        echo "</tr>";
      echo "</form>";
    }
  }
} else {
  echo "<p>No tasks available.</p>";
}
?>
</table>
