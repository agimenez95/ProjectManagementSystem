<br>
<div class='col-md-1'></div>
<div class='col-md-5'>
<form class="" action="../logic/upgradeaccount.php" method="post">
  <?php
  include "../logic/userdropdown.php";
  $usermanager = new UserManager(getDB());
  $allUsers = $usermanager->allNewStarters();
  if ($allUsers) {
    echo '<input  class="btn btn-success" type="submit" name="makeManager" value="Upgrade">';
  }
  ?>
</form>
</div>
