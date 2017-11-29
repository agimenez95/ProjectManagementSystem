<?php
require 'prereq.php';
//logout code I have used in another project
if(isset($_COOKIE[session_name()])){
  setcookie('PHPSESSID', '', time()-10);
}
$_SESSION = array();
session_destroy();
header("location: ../view/index.php");
exit();
?>
