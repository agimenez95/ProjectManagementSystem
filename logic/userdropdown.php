<?php
$usermanager = new UserManager(getDB());
$allUsers = $usermanager->allNewStarters();
if ($allUsers) {
  echo "<select class='selectpicker' name='option0'>";
    foreach ($allUsers as $id => $user) {
      if ($_SESSION['option0'] == $id) {
        echo "<option selected value =".$id.">$user</option>";
      } else {
        echo "<option value =".$id.">$user</option>";
      }
    }
  echo "</select>";
} else {
  echo "<p>There are no new starters.</p>";
}
echo "<br><br>";
?>
