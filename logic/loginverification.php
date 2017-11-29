<?php
// check login and create SESSION and count attempts
require 'prereq.php';

$custman = new CustomerManager(getDB());
$customer = $custman->byEmail($_POST['email']);

if ($customer && $customer->passwordValid($_POST['password'])){
  $_SESSION["userId"] = $customer->getID();
  $_SESSION['login'] = 1;
  header('Location: '.$_SERVER['HTTP_REFERER']);
} else {
  $_SESSION['login'] = 0;
  header('Location: '.$_SERVER['HTTP_REFERER']);
}

?>
