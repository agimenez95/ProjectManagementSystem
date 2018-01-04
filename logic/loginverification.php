<?php
// check login and create SESSION and count attempts
require 'prereq.php';

$userman = new UserManager(getDB());
$user = $userman->byEmail($_POST['email']);

if ($user && $user->passwordValid($_POST['password']) && !$user->getDisabled()){
  $_SESSION["userId"] = $user->getID();
  if ($userman->isManagerById($_SESSION["userId"]) == 1){
    $_SESSION['login'] = 2;
  } else {
    $_SESSION['login'] = 1;
  }
  $_SESSION['page'] = 1;
  header('Location: '.$_SERVER['HTTP_REFERER']);
} else {
  header('Location: '.$_SERVER['HTTP_REFERER']);
}

?>
