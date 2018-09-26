<?php session_start();
require('config.php');
?>
<?php

$removelist = $bdd->exec("DELETE FROM lists WHERE id =" . $_GET['list'] . "");
header('location: viewproject.php?project=' . $_GET['project'] . '');
?>
