<?php 

session_start();
session_destroy();
setcookie("userid", "", time()-3600);
setcookie("update_id", "", time()-3600);

header("Location: index.php");
die;

?>