<?php
require 'db.php';
spl_autoload_register(function ($className){
  require '../classes/'.strtolower($className).'.php';
});
include '../includes/sessions.inc.php';
?>
