<?php session_start();
require('config.php');
?>
<?php

$removeproject = $bdd->exec("DELETE FROM projects WHERE id =" . $_GET['project'] . "");
header('location: index.php');
?>
