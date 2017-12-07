<?php
include_once "prereq.php";
$usermanager = new UserManager(getDB());
$user = $usermanager->byId($_POST['option0']);
$usermanager->upgradeUser($user);
header('Location: ../view/index.php');
?>
