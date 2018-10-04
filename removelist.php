<?php session_start();
require('config.php');
?>
<?php
// Check if user connected
if (!empty($_SESSION['id'])) {
  // Remove list by the id of the list
$removelist = $bdd->exec("DELETE FROM lists WHERE id =" . $_GET['list'] . "");
header('location: viewproject.php?project=' . $_GET['project'] . '');
} else {
  header('location: index.php');
}
?>
